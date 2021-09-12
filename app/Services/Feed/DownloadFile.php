<?php

namespace App\Services\Feed;

use App\Models\Shop;
use GuzzleHttp\Client;

class DownloadFile
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function run(Shop $shop)
    {
        $this->client->get($shop->feed_url, [
            'sink' => FileName::build($shop->id),
            'headers' => ['Accept-Encoding' => 'gzip'],
        ]);
    }
}
