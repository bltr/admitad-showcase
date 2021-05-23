<?php


namespace App\Feed;


use App\Models\Feed\Categories;
use App\Models\Feed\Offers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SyncFile
{
    private ReadFile $readFile;

    public function __construct(ReadFile $readFile)
    {
        $this->readFile = $readFile;
    }

    public function sync(int $shopId)
    {
        try {
            $this->readFile->init(FileName::build($shopId));
            $this->syncEntries($shopId, 'category');
            $this->syncEntries($shopId, 'offer');
        } catch (\Throwable $exception) {
            Log::error('feed sync: ' . $exception->getMessage() . ' ' . $exception->getLine());
        }
    }

    private function syncEntries(int $shopId, string $tag_name)
    {
        $hashs = [];
        $this->query($tag_name)->where('shop_id', $shopId)->select('hash', 'outer_id')->chunk(10000, function ($entries) use (&$hashs) {
            $hashs += $entries->pluck('hash', 'outer_id')->all();
        });

        DB::beginTransaction();
        $time = new \DateTime();
        foreach ($this->readFile->readEntries($tag_name) as $entry) {
            $json_entry = json_encode($entry, JSON_UNESCAPED_UNICODE);
            $hash = sha1($json_entry);
            $id = $entry['id'];

            if (!isset($hashs[$id])) {
                $this->query($tag_name)->insert([
                    'created_at' => $time,
                    'updated_at' => $time,
                    'outer_id' => $id,
                    'shop_id' => $shopId,
                    'hash' => $hash,
                    'data' => $json_entry
                ]);
            }

            if (isset($hashs[$id]) && $hashs[$id] !== $hash) {
                $this->query($tag_name)
                    ->where('shop_id', $shopId)
                    ->where('outer_id', $id)
                    ->update(['updated_at' => $time, 'hash' => $hash, 'data' => $json_entry]);
            }

            if (isset($hashs[$id])) {
                unset($hashs[$id]);
            }
        }

        if (!empty($hashs)) {
            $this->query($tag_name)->where('shop_id', $shopId)->whereIn('outer_id', array_map(fn($value) => (string) $value, array_keys($hashs)))->delete();
        }

        DB::commit();
    }

    private function query($tag_name)
    {
        return $tag_name === 'offer' ? Offers::query() : Categories::query();
    }
}
