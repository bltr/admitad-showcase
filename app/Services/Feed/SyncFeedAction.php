<?php


namespace App\Services\Feed;


use App\Models\FeedCategory;
use App\Models\FeedOffer;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SyncFeedAction
{
    private XMLFileReader $fileReader;
    private int $shopId;

    public function __construct(XMLFileReader $fileReader)
    {
        $this->fileReader = $fileReader;
    }

    public function __invoke(Shop $shop)
    {
        $this->shopId = $shop->id;
        try {
            $this->sync();
        } catch (\Throwable $exception) {
            Log::error('feed sync: ' . $exception->getMessage() . ' ' . $exception->getLine());
        }
    }

    public function sync()
    {
        try {
            DB::beginTransaction();
            $this->fileReader->init($this->shopId);
            $this->syncEntriesfForTag('category');
            $this->syncEntriesfForTag('offer', ['picture']);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }

        $this->fixCategoriesTree();
        $this->seedFeedCategoryIdOfOffers();
    }

    private function syncEntriesfForTag(string $tag_name, $arrayble_tag = [])
    {
        $hashs = [];
        $this->query($tag_name)
            ->where('shop_id', $this->shopId)
            ->select('hash', 'outer_id')
            ->chunk(10000, function ($entries) use (&$hashs) {
                $hashs += $entries->pluck('hash', 'outer_id')->all();
            });

        $time = new \DateTime();
        foreach ($this->fileReader->getIterator($tag_name) as $entry) {
            foreach ($arrayble_tag as $tag) {
                $entry[Str::plural($tag)] = (array) ($entry[$tag] ?? []);
                unset($entry[$tag]);
            }

            $json_entry = json_encode($entry, JSON_UNESCAPED_UNICODE);
            $hash = sha1($json_entry);
            $id = $entry['id'];

            if (!isset($hashs[$id])) {
                $this->query($tag_name)->insert([
                    'created_at' => $time,
                    'updated_at' => $time,
                    'outer_id' => $id,
                    'shop_id' => $this->shopId,
                    'hash' => $hash,
                    'data' => $json_entry
                ]);
            }

            if (isset($hashs[$id]) && $hashs[$id] !== $hash . 'b') {
                $this->query($tag_name)
                    ->where('shop_id', $this->shopId)
                    ->where('outer_id', $id)
                    ->update(['updated_at' => $time, 'hash' => $hash, 'data' => $json_entry]);
            }

            if (isset($hashs[$id])) {
                unset($hashs[$id]);
            }
        }

        if (!empty($hashs)) {
            $this->query($tag_name)
                ->where('shop_id', $this->shopId)
                ->whereIn('outer_id', array_map(fn($value) => (string) $value, array_keys($hashs)))
                ->delete();
        }
    }

    private function query($tag_name)
    {
        return $tag_name === 'offer' ? FeedOffer::query() : FeedCategory::query();
    }

    private function fixCategoriesTree(): void
    {
        $this->seedParenIdOfCategories();
        FeedCategory::scoped(['shop_id' => $this->shopId])->fixTree();
    }

    private function seedParenIdOfCategories(): void
    {
        DB::update(<<<QUERY
                update feed_categories set parent_id = f_c.id
                from feed_categories as f_c
                where f_c.outer_id = (feed_categories.data ->> 'parentId')
                  and (feed_categories.data ->> 'parentId') <> 'null'
                  and f_c.shop_id = {$this->shopId}
                  and feed_categories.shop_id = {$this->shopId};
            QUERY
        );
    }

    private function seedFeedCategoryIdOfOffers(): void
    {
        DB::update(
            <<<QUERY
                update feed_offers set feed_category_id = feed_categories.id
                from feed_categories
                where feed_categories.outer_id=feed_offers.data ->> 'categoryId'
                 and feed_categories.shop_id = {$this->shopId}
                 and feed_offers.shop_id = {$this->shopId};
            QUERY
        );
    }
}
