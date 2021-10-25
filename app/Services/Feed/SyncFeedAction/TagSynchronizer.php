<?php

namespace App\Services\Feed\SyncFeedAction;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

abstract class TagSynchronizer
{
    protected const BUFFER_SIZE = 500;

    private XMLFileReader $xmlIterator;

    private Shop $shop;

    private Carbon $synchronized_at;

    public function __construct(XMLFileReader $xmlIterator)
    {
        $this->xmlIterator = $xmlIterator;
    }

    abstract protected function query(): Builder;

    abstract protected function processEntry(array $entry): array;

    abstract protected function tagName(): string;

    public function sync(Shop $shop, Carbon $synchronized_at)
    {
        $this->shop = $shop;
        $this->synchronized_at = $synchronized_at;
        $buffer = [];

        $this->xmlIterator->open($shop->feed_file_name);
        foreach ($this->xmlIterator->getIterator($this->tagName()) as $entry) {
            $buffer[$entry['id']] = $entry;

            if (count($buffer) === static::BUFFER_SIZE) {
                $this->syncChunk($buffer);
                $buffer = [];
            }
        }

        if (count($buffer) > 0) {
            $this->syncChunk($buffer);
        }

        $this->query()
            ->where('shop_id', $this->shop->id)
            ->where('synchronized_at', '<>', $this->synchronized_at)
            ->delete();
    }

    private function syncChunk(array $entries)
    {
        $values_to_upsert = [];

        $hashs = $this->query()
            ->where('shop_id', $this->shop->id)
            ->whereIn('outer_id', array_keys($entries))
            ->pluck('hash', 'outer_id')
            ->all();

        foreach ($entries as $entry) {
            $entry = $this->processEntry($entry);

            $json = json_encode($entry, JSON_UNESCAPED_UNICODE);
            $hash = sha1($json);
            $outer_id = $entry['id'];

            if (!isset($hashs[$outer_id]) || ($hashs[$outer_id] !== $hash)) {
                $values_to_upsert[] = [
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

        $this->query()->upsert(
            $values_to_upsert,
            ['shop_id', 'outer_id'],
            ['updated_at', 'synchronized_at', 'hash', 'data']
        );

        if (!empty($hashs)) {
            $this->query()
                ->where('shop_id', $this->shop->id)
                ->whereIn('outer_id', array_map(fn($value) => (string) $value, array_keys($hashs)))
                ->update(['synchronized_at' => $this->synchronized_at]);
        }
    }
}
