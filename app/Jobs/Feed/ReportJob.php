<?php

namespace App\Jobs\Feed;

use App\Models\Shop;
use App\Services\Report\CompositeReport;
use App\Services\Report\ReportService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    private Shop $shop;

    public function __construct(Shop $shop)
    {

        $this->shop = $shop;
    }

    public function handle(ReportService $reportService)
    {
        $reportService->build(CompositeReport::feedReportByShop(), $this->shop->id);
        $reportService->build(CompositeReport::feedReportTotal());
    }
}
