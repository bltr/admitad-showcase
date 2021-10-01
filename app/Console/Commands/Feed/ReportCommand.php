<?php

namespace App\Console\Commands\Feed;

use App\Services\Report\ReportService;
use App\Models\Shop;
use App\Services\Report\CompositeReport;
use Illuminate\Console\Command;

class ReportCommand extends Command
{
    protected $signature = 'feed:report {shop_id?* :  список id магазинов}';

    protected $description = 'Сформировать отчеты фидов';

    public function handle(ReportService $reportService)
    {
        $shop_ids = $this->argument('shop_id');

        Shop::when($shop_ids, fn($q) => $q->whereIn('id', $shop_ids))
            ->get()
            ->each(fn($shop) => $reportService->build(CompositeReport::feedReportByShop(), $shop->id));

        $reportService->build(CompositeReport::feedReportTotal());

        return 0;
    }
}
