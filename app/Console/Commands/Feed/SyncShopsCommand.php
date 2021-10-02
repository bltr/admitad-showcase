<?php

namespace App\Console\Commands\Feed;

use App\Services\Feed\SyncShopsAction;
use Illuminate\Console\Command;

class SyncShopsCommand extends Command
{
    protected $signature = 'feed:sync-shops';

    protected $description = 'Синхронизировать магазины';

    public function handle(SyncShopsAction $syncShops)
    {
        $syncShops();

        return 0;
    }
}
