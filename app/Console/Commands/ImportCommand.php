<?php

namespace App\Console\Commands;

use App\Jobs\Catalog\ImportJob;
use App\Jobs\Feed\ReportJob;
use App\Jobs\Feed\DownloadFileJob;
use App\Jobs\Feed\SyncFileJob;
use App\Models\Shop;
use App\Services\Report\CompositeReport;
use App\Services\Report\ReportService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class ImportCommand extends Command
{
    protected $signature = 'import {shop_id?* : список id магазинов}';

    protected $description = 'Полный импорт';

    public function handle(ReportService $reportService)
    {
        $shop_ids = $this->argument('shop_id');
        $query = Shop::active();
        $shops = $shop_ids ? $query->whereIn('id', $shop_ids)->get() : $query->get() ;

        Bus::batch($shops->map(function ($shop) {
            return [
                new DownloadFileJob($shop),
                new SyncFileJob($shop),
                new ReportJob($shop),
                new ImportJob($shop)
            ];
        }))->then(function () use ($reportService) {
            $reportService->build(CompositeReport::catalogReportTotal());
        })->dispatch();

        return 0;
    }
}
