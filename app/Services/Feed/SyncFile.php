<?php


namespace App\Services\Feed;


use App\Models\FeedCategory;
use App\Models\FeedOffer;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SyncFile
{
    private ReadFile $readFile;

    public function __construct(ReadFile $readFile)
    {
        $this->readFile = $readFile;
    }

    public function run(Shop $shop)
    {
        try {
            $this->readFile->init(FileName::build($shop->id));

            $this->syncEntries($shop->id, 'category');
            FeedCategory::scoped(['shop_id' => $shop->id])->fixTree();

            $this->syncEntries($shop->id, 'offer', ['picture']);
        } catch (\Throwable $exception) {
            Log::error('feed sync: ' . $exception->getMessage() . ' ' . $exception->getLine());
        }
    }

    private function syncEntries(int $shopId, string $tag_name, $arrayble_tag = [])
    {
        $hashs = [];
        $this->query($tag_name)
            ->where('shop_id', $shopId)
            ->select('hash', 'outer_id')
            ->chunk(10000, function ($entries) use (&$hashs) {
                $hashs += $entries->pluck('hash', 'outer_id')->all();
            });

        DB::beginTransaction();
        $time = new \DateTime();
        foreach ($this->readFile->readEntries($tag_name) as $entry) {
            foreach ($arrayble_tag as $tag) {
                $entry[Str::plural($tag)] = (array) ($entry[$tag] ?? []);
                unset($entry[$tag]);
            }

            $json_entry = json_encode($entry, JSON_UNESCAPED_UNICODE);
            $hash = sha1($json_entry);
            $id = $entry['id'];

            if (!isset($hashs[$id])) {
                $this->query($tag_name)->insert($this->appendData($tag_name, [
                    'created_at' => $time,
                    'updated_at' => $time,
                    'outer_id' => $id,
                    'shop_id' => $shopId,
                    'hash' => $hash,
                    'data' => $json_entry
                ], $entry));
            }

            if (isset($hashs[$id]) && $hashs[$id] !== $hash . 'b') {
                $this->query($tag_name)
                    ->where('shop_id', $shopId)
                    ->where('outer_id', $id)
                    ->update($this->appendData($tag_name, ['updated_at' => $time, 'hash' => $hash, 'data' => $json_entry], $entry));
            }

            if (isset($hashs[$id])) {
                unset($hashs[$id]);
            }
        }

        if (!empty($hashs)) {
            $this->query($tag_name)
                ->where('shop_id', $shopId)
                ->whereIn('outer_id', array_map(fn($value) => (string) $value, array_keys($hashs)))
                ->delete();
        }

        DB::commit();
    }

    private function query($tag_name)
    {
        return $tag_name === 'offer' ? FeedOffer::query() : FeedCategory::query();
    }

    private function appendData($tag_name, $data, $entry)
    {
        if ($tag_name === 'category') {
            $data['parent_id'] = $entry['parentId'] ?? null;
            return $data;
        }

        return $data;
    }
}
