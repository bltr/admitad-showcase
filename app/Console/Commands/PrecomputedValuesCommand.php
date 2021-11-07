<?php

namespace App\Console\Commands;

use App\Models\Shop;
use App\Services\PrecomputedValues\PrecomputedValuesService;
use Illuminate\Console\Command;

class PrecomputedValuesCommand extends Command
{
    protected $signature = 'compute-values';

    protected $description = 'Предварительные вычисления';

    public function handle(PrecomputedValuesService $computingService)
    {
        $computingService->calc();

        return 0;
    }
}
