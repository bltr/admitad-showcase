<?php

namespace App\Console\Commands\Catalog;

use App\Services\Report\ReportService;
use App\Services\Report\CompositeReport;
use Illuminate\Console\Command;

class ReportCommand extends Command
{
    protected $signature = 'catalog:report';

    protected $description = 'Сформировать отчеты каталога';

    public function handle(ReportService $reportService)
    {
        $reportService->build(CompositeReport::catalogReportTotal());

        return 0;
    }
}
