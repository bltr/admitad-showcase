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
        $this->client->get($shop->feed_url, [
            'sink' => FileName::build($shop->id),
            'headers' => ['Accept-Encoding' => 'gzip'],
        ]);
    }
}
