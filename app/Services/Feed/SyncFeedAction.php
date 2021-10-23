<?php


namespace App\Services\Feed;


use App\Models\FeedCategory;
use App\Models\FeedOffer;
use App\Models\Shop;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SyncFeedAction
{
    private const BUFFER_SIZE = 500;

    private XMLFileReader $xmlIterator;

    private Shop $shop;

    private Carbon $synchronized_at;

    private array $arraybleTag = ['picture'];

    public function __construct(XMLFileReader $xmlIterator)
    {
        $this->xmlIterator = $xmlIterator;
    }

    public function __invoke(Shop $shop)
    {
        $this->shop = $shop;
        $this->synchronized_at = now();

        try {
            $this->sync();
        } catch (\Throwable $exception) {
            Log::error('feed sync: ' . $exception->getMessage() . ' ' . $exception->getLine());
        }
    }

    public function sync()
    {
        $this->xmlIterator->open($this->shop->feed_file_name);

        $this->syncEntriesForTag('category');
        $this->syncEntriesForTag('offer');

        $this->fixCategoriesTree();
        $this->seedFeedCategoryIdOfOffers();
    }

    private function syncEntriesForTag(string $tagName)
    {
        $buffer = [];

        foreach ($this->xmlIterator->getIterator($tagName) as $entry) {
            $buffer[$entry['id']] = $entry;

            if (count($buffer) === static::BUFFER_SIZE) {
                $this->syncChunk($tagName, $buffer);
                $buffer = [];
            }
        }

        if (count($buffer) > 0) {
            $this->syncChunk($tagName, $buffer);
        }

        $this->query($tagName)
            ->where('shop_id', $this->shop->id)
            ->where('synchronized_at', '<>', $this->synchronized_at)
            ->delete();
    }

    private function syncChunk(string $tagName, array $entries)
    {
        $hashs = $this->query($tagName)
            ->where('shop_id', $this->shop->id)
            ->whereIn('outer_id', array_keys($entries))
            ->pluck('hash', 'outer_id')
            ->all();
        $values = [];

        foreach ($entries as $entry) {
            foreach ($this->arraybleTag as $tag) {
                if (isset($entry[$tag])) {
                    $entry[Str::plural($tag)] = (array)($entry[$tag] ?? []);
                    unset($entry[$tag]);
                }
            }

            $json = json_encode($entry, JSON_UNESCAPED_UNICODE);
            $hash = sha1($json);
            $outer_id = $entry['id'];

            if (!isset($hashs[$outer_id]) || ($hashs[$outer_id] !== $hash)) {
                $values[] = [
                    'created_at' => $this->synchronized_at,
                    'updated_at' => $this->synchronized_at,
                    'synchronized_at' => $this->synchronized_at,
                    'outer_id' => $outer_id,
                    'shop_id' => $this->shop->id,
                    'hash' => $hash,
                    'data' => $json
                ];
                unset($hashs[$outer_id]);
            }
        }

        $this->query($tagName)->upsert(
            $values,
            ['shop_id', 'outer_id'],
            ['updated_at', 'synchronized_at', 'hash', 'data']
        );

        if (!empty($hashs)) {
            $this->query($tagName)
                ->where('shop_id', $this->shop->id)
                ->whereIn('outer_id', array_map(fn($value) => (string) $value, array_keys($hashs)))
                ->update(['synchronized_at' => $this->synchronized_at]);
        }
    }

    private function query($tagName)
    {
        return $tagName === 'offer' ? FeedOffer::query() : FeedCategory::query();
    }

    private function fixCategoriesTree(): void
    {
        $this->seedParentIdOfCategories();
        FeedCategory::scoped(['shop_id' => $this->shop->id])->fixTree();
    }

    private function seedParentIdOfCategories(): void
    {
        DB::update(<<<QUERY
                update feed_categories set parent_id = f_c.id
                from feed_categories as f_c
                where f_c.outer_id = (feed_categories.data ->> 'parentId')
                  and (feed_categories.data ->> 'parentId') <> 'null'
                  and f_c.shop_id = {$this->shop->id}
                  and feed_categories.shop_id = {$this->shop->id};
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
                 and feed_categories.shop_id = {$this->shop->id}
                 and feed_offers.shop_id = {$this->shop->id};
            QUERY
        );
    }
}
