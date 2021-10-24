<?php

namespace App\Console\Commands\Feed;

use App\Jobs\Feed\DownloadFileJob;
use App\Jobs\Feed\SyncFeedJob;
use App\Models\Shop;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class SyncQueuedCommand extends Command
{
    protected $signature = 'feed:sync-queued';

    protected $description = 'Синхронизация фида';

    public function handle()
    {
        Shop::whereNotNull('feed_url')
            ->get()
            ->each(function($shop) {
                Bus::chain([
                    new DownloadFileJob($shop),
                    new SyncFeedJob($shop),
                ])->dispatch();
            });

        return 0;
    }
}
