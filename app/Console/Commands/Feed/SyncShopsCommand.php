<?php

namespace App\Console\Commands\Feed;

use App\Services\Feed\SyncShops;
use Illuminate\Console\Command;

class SyncShopsCommand extends Command
{
    protected $signature = 'feed:sync-shops';

    protected $description = 'Синхронизировать магазины';

    public function handle(SyncShops $syncShops)
    {
        $syncShops->run();

        return 0;
    }
}
