<?php

namespace App\Console\Commands\Feed;

use App\Services\Feed\AnalyticServiceTotal;
use App\Services\Feed\AnalyticsServiceByShop;
use App\Models\Shop;
use Illuminate\Console\Command;

class AnalyticsCommand extends Command
{
    protected $signature = 'feed:analytics {shop_id?* :  список id магазинов}';

    protected $description = 'Сформировать отчеты аналитики фидов';

    public function handle(AnalyticsServiceByShop $analyticsService, AnalyticServiceTotal $analyticServiceTotal)
    {
        $shop_ids = $this->argument('shop_id');
        $shops = $shop_ids ? Shop::whereIn('id', $shop_ids)->get() : Shop::all() ;
        $shops->each(fn($shop) => $analyticsService->build($shop->id));

        $analyticServiceTotal->build();

        return 0;
    }
}
