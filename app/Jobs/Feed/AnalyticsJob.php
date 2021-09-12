<?php

namespace App\Jobs\Feed;

use App\Models\Shop;
use App\Services\Feed\AnalyticsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AnalyticsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Shop $shop;

    public function __construct(Shop $shop)
    {

        $this->shop = $shop;
    }

    public function handle(AnalyticsService $service)
    {
        $service->build($this->shop);
    }
}
