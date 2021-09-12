<?php

namespace App\Console\Commands\Feed;

use App\Services\Feed\AnalyticsService;
use App\Models\Shop;
use Illuminate\Console\Command;

class AnalyticsCommand extends Command
{
    protected $signature = 'feed:analytics {shop_id?* :  список id магазинов}';

    protected $description = 'Сформировать отчеты аналитики фидов';

    public function handle(AnalyticsService $service)
    {
        $shop_ids = $this->argument('shop_id');
        $shops = $shop_ids ? Shop::whereIn('id', $shop_ids)->get() : Shop::all() ;
        $service->build($shops);

        return 0;
    }
}
