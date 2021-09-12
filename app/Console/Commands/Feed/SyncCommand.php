<?php

namespace App\Console\Commands\Feed;

use App\Models\Shop;
use App\Services\Feed\DownloadFile;
use App\Services\Feed\SyncFile;
use Illuminate\Console\Command;

class SyncCommand extends Command
{
    protected $signature = 'feed:sync {shop_id?* : список id магазинов}';

    protected $description = 'Синхронизация фида';

    public function handle(SyncFile $syncFile, DownloadFile $downloadFile)
    {
        $shop_ids = $this->argument('shop_id');
        $shops = $shop_ids ? Shop::whereIn('id', $shop_ids)->get() : Shop::all() ;

        $shops->each(function($shop) use ($syncFile, $downloadFile) {
            $downloadFile->run($shop);
            $syncFile->run($shop->id);
        });

        return 0;
    }
}
