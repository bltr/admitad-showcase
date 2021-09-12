<?php

namespace App\Console\Commands;

use App\Services\Catalog\Analytics\AnalyticsService;
use Illuminate\Console\Command;

class CatalogAnalyticsCommand extends Command
{
    protected $signature = 'catalog:analytics';

    protected $description = 'Сформировать отчеты аналитики каталога';

    public function handle(AnalyticsService $service)
    {
        $service->build();

        return 0;
    }
}
