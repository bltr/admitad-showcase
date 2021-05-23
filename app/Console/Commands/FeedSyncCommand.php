<?php

namespace App\Console\Commands;

use App\Jobs\Feed\DownloadFileJob;
use App\Jobs\Feed\SyncFileJob;
use App\Models\Shop;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class FeedSyncCommand extends Command
{
    protected $signature = 'feed:sync {shop_id?*} : Ids of shops}';

    protected $description = 'Push download and sync feeds jobs of all or specified shops';

    public function handle()
    {
        $shop_ids = $this->argument('shop_id');
        $shops = $shop_ids ? Shop::whereIn('id', $shop_ids)->get() : Shop::all() ;
        $shops->each(fn($shop) => Bus::chain([new DownloadFileJob($shop), new SyncFileJob($shop->id)])->dispatch());

        return 0;
    }
}
