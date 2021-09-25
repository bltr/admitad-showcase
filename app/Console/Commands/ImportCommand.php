<?php

namespace App\Console\Commands;

use App\Jobs\Catalog\ImportJob;
use App\Jobs\Feed\AnalyticsJob;
use App\Jobs\Feed\DownloadFileJob;
use App\Jobs\Feed\SyncFileJob;
use App\Models\Shop;
use App\Services\Catalog\AnalyticsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class ImportCommand extends Command
{
    protected $signature = 'import {shop_id?* : список id магазинов}';

    protected $description = 'Полный импорт';

    public function handle(AnalyticsService $analyticsService)
    {
        $shop_ids = $this->argument('shop_id');
        $query = Shop::active();
        $shops = $shop_ids ? $query->whereIn('id', $shop_ids)->get() : $query->get() ;

        Bus::batch($shops->map(function ($shop) {
            return [
                new DownloadFileJob($shop),
                new SyncFileJob($shop),
                new AnalyticsJob($shop),
                new ImportJob($shop)
            ];
        }))->then(function () use ($analyticsService) {
            $analyticsService->build();
        })->dispatch();

        return 0;
    }
}
