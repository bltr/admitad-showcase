<?php

namespace App\Console\Commands\Catalog;

use App\Services\Analytics\AnalyticsService;
use App\Services\Analytics\CompositeReport;
use Illuminate\Console\Command;

class AnalyticsCommand extends Command
{
    protected $signature = 'catalog:analytics';

    protected $description = 'Сформировать отчеты аналитики каталога';

    public function handle(AnalyticsService $analyticsService)
    {
        $analyticsService->build(CompositeReport::catalogReportTotal());

        return 0;
    }
}
