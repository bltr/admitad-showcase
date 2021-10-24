<?php

namespace App\Console\Commands\Feed;

use App\Models\Shop;
use App\Services\Feed\DownloadFileAction;
use App\Services\Feed\SyncFeedAction;
use Illuminate\Console\Command;

class SyncCommand extends Command
{
    protected $signature = 'feed:sync {shop_id* : список id магазинов}';

    protected $description = 'Синхронизация фида';

    public function handle(SyncFeedAction $syncFileAction, DownloadFileAction $downloadFileAction)
    {
        $shop_ids = $this->argument('shop_id');

        Shop::whereNotNull('feed_url')
            ->whereIn('id', $shop_ids)
            ->get()
            ->each(function($shop) use ($syncFileAction, $downloadFileAction) {
                $downloadFileAction($shop);
                $syncFileAction($shop);
            });

        return 0;
    }
}
