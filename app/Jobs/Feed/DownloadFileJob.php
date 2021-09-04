<?php

namespace App\Jobs\Feed;

use App\Models\Shop;
use App\Services\Feed\FileName;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DownloadFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 1800;

    private Shop $shop;

    public function __construct(Shop $shop)
    {
        $this->shop = $shop;
    }

    public function handle(Client $client)
    {
        $client->get($this->shop->feed_url, [
            'sink' => FileName::build($this->shop->id),
            'headers' => ['Accept-Encoding' => 'gzip'],
        ]);
    }
}
