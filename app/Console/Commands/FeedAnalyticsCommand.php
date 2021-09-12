<?php

namespace App\Console\Commands;

use App\Services\Feed\Analytics\AnalyticsService;
use App\Models\Shop;
use Illuminate\Console\Command;

class FeedAnalyticsCommand extends Command
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
