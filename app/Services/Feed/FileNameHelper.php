<?php


namespace App\Services\Feed;


class FileNameHelper
{
    public function __invoke(int $shop_id): string
    {
        $dir_name = storage_path('feeds');
        if (!is_dir($dir_name)) {
            // to prevent race conditions
            try { mkdir($dir_name); } catch (\ErrorException $e) {}
        }

        return $dir_name . '/' . $shop_id . '.xml';
    }
}
