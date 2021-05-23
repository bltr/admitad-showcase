<?php


namespace App\Feed;


class FileName
{
    public static function build(int $shop_id): string
    {
        $dir_name = storage_path('feeds');
        if (!is_dir($dir_name)) {
            // to prevent race conditions
            try { mkdir($dir_name); } catch (\ErrorException $e) {}
        }

        return $dir_name . '/' . $shop_id . '.xml';
    }
}
