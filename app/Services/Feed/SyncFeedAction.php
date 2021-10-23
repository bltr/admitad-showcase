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
    private const BUFFER_SIZE = 1000;

    private XMLIterator $xmlIterator;

    private Shop $shop;

    public function __construct(XMLIterator $xmlIterator)
    {
        $this->xmlIterator = $xmlIterator;
    }

    public function __invoke(Shop $shop)
    {
        config()->set('flare.reporting.maximum_number_of_collected_queries', 1);

        $this->shop = $shop;
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
        $this->syncEntriesForTag('offer', ['picture']);

        $this->fixCategoriesTree();
        $this->seedFeedCategoryIdOfOffers();
    }

    private function syncEntriesForTag(string $tagName, array $arraybleTag = [])
    {
        $buffer = [];
        $time = now();

        foreach ($this->xmlIterator->getIterator($tagName) as $entry) {
            $buffer[$entry['id']] = $entry;

            if (count($buffer) === static::BUFFER_SIZE) {
                $this->syncChunk($tagName, $buffer, $arraybleTag, $time);
                $buffer = [];
            }
        }

        if (count($buffer) > 0) {
            $this->syncChunk($tagName, $buffer, $arraybleTag, $time);
        }

        $this->query($tagName)
            ->where('shop_id', $this->shop->id)
            ->where('synchronized_at', '<>', $time)
            ->delete();
    }

    private function syncChunk(string $tagName, array $entries, array $arraybleTag, \DateTime $time)
    {
        $hashs = $this->query($tagName)
            ->where('shop_id', $this->shop->id)
            ->whereIn('outer_id', array_keys($entries))
            ->pluck('hash', 'outer_id')
            ->all();
        $values = [];

        foreach ($entries as $entry) {
            foreach ($arraybleTag as $tag) {
                $entry[Str::plural($tag)] = (array)($entry[$tag] ?? []);
                unset($entry[$tag]);
            }

            $jsonEntry = json_encode($entry, JSON_UNESCAPED_UNICODE);
            $hash = sha1($jsonEntry);
            $id = $entry['id'];

            if (!isset($hashs[$id])) {
                $values[] = [
                    'created_at' => $time,
                    'updated_at' => $time,
                    'synchronized_at' => $time,
                    'outer_id' => $id,
                    'shop_id' => $this->shop->id,
                    'hash' => $hash,
                    'data' => $jsonEntry
                ];
            }

            if (isset($hashs[$id]) && $hashs[$id] !== $hash) {
                $values[] = [
                    'created_at' => null,
                    'updated_at' => $time,
                    'synchronized_at' => $time,
                    'outer_id' => $id,
                    'shop_id' => $this->shop->id,
                    'hash' => $hash,
                    'data' => $jsonEntry
                ];
                unset($hashs[$id]);
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
                ->update(['synchronized_at' => $time]);
        }
    }

    private function query($tagName)
    {
        return $tagName === 'offer' ? FeedOffer::query() : FeedCategory::query();
    }

    private function fixCategoriesTree(): void
    {
        $this->seedParentIdOfCategories();
        FeedCategory::scoped(['shop_id' => $this->shop])->fixTree();
    }

    private function seedParentIdOfCategories(): void
    {
        DB::update(<<<QUERY
                update feed_categories set parent_id = f_c.id
                from feed_categories as f_c
                where f_c.outer_id = (feed_categories.data ->> 'parentId')
                  and (feed_categories.data ->> 'parentId') <> 'null'
                  and f_c.shop_id = {$this->shop}
                  and feed_categories.shop_id = {$this->shop};
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
                 and feed_categories.shop_id = {$this->shop}
                 and feed_offers.shop_id = {$this->shop};
            QUERY
        );
    }
}
