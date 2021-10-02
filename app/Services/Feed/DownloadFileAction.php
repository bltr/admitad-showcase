<?php

namespace App\Services\Feed;

use App\Models\Shop;
use GuzzleHttp\Client;

class DownloadFileAction
{
    private Client $client;
    private FileNameHelper $fileName;

    public function __construct(Client $client, FileNameHelper $fileName)
    {
        $this->client = $client;
        $this->fileName = $fileName;
    }

    public function __invoke(Shop $shop)
    {
        $this->client->get($shop->feed_url, [
            'sink' => ($this->fileName)($shop->id),
            'headers' => ['Accept-Encoding' => 'gzip'],
        ]);
    }
}
