<?php

namespace App\Console\Commands\Catalog;

use App\Services\Catalog\AnalyticsService;
use Illuminate\Console\Command;

class AnalyticsCommand extends Command
{
    protected $signature = 'catalog:analytics';

    protected $description = 'Сформировать отчеты аналитики каталога';

    public function handle(AnalyticsService $analyticsService)
    {
        $analyticsService->build();

        return 0;
    }
}
