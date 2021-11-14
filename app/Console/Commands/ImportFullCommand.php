<?php

namespace App\Console\Commands;

use App\Jobs\Catalog\ImportJob;
use App\Jobs\Feed\DownloadFileJob;
use App\Jobs\Feed\SyncFeedJob;
use App\Models\Shop;
use App\Services\PrecomputedValues\PrecomputedValuesService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class ImportFullCommand extends Command
{
    protected $signature = 'import:full';

    protected $description = 'Полный импорт';

    public function handle(PrecomputedValuesService $valuesService)
    {
        Bus::batch(
            Shop::active()->get()
            ->map(function ($shop) {
                return [
                    new DownloadFileJob($shop),
                    new SyncFeedJob($shop),
                    new ImportJob($shop)
                ];
            })
        )->then(function () use ($valuesService) {
            $valuesService->calc();
        })->dispatch();

        return 0;
    }
}
