<?php

namespace App\Console\Commands;

use App\Jobs\Catalog\ImportJob;
use App\Jobs\Feed\DownloadFileJob;
use App\Jobs\Feed\SyncFeedJob;
use App\Models\Shop;
use App\Services\PrecomputedValues\PrecomputedValuesService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class ImportCommand extends Command
{
    protected $signature = 'import {shop_id?* : список id магазинов}';

    protected $description = 'Полный импорт';

    public function handle(PrecomputedValuesService $valuesService)
    {
        $shop_ids = $this->argument('shop_id');
        $query = Shop::active();
        $shops = $shop_ids ? $query->whereIn('id', $shop_ids)->get() : $query->get() ;

        Bus::batch($shops->map(function ($shop) {
            return [
                new DownloadFileJob($shop),
                new SyncFeedJob($shop),
                new ImportJob($shop)
            ];
        }))->then(function () use ($valuesService) {
            $valuesService->calc();
        })->dispatch();

        return 0;
    }
}
