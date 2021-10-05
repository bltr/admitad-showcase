<?php

namespace App\Services\Feed;

use App\Models\Shop;
use GuzzleHttp\Client;

class DownloadFileAction
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function __invoke(Shop $shop)
    {
        $this->checkDirExisten($shop);
        $this->client->get($shop->feed_url, [
            'sink' => $shop->feed_file_name,
            'headers' => ['Accept-Encoding' => 'gzip'],
        ]);
    }

    private function checkDirExisten(Shop $shop): void
    {
        $dirName = dirname($shop->feed_file_name);
        if (!is_dir($dirName)) {
            // to prevent race conditions
            try {
                mkdir($dirName);
            } catch (\ErrorException $e) {
            }
        }
    }
}
