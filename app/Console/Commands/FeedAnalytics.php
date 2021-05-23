<?php

namespace App\Console\Commands;

use App\Feed\Analytics\CompositeReportFactory;
use App\Models\Feed\Analytics;
use App\Models\Shop;
use Illuminate\Console\Command;

class FeedAnalytics extends Command
{
    protected $signature = 'feed:analytics {shop_id?*} : Ids of shops';

    protected $description = 'Build analytics report';

    public function handle(CompositeReportFactory $factory)
    {
        $report = $factory->build();

        $shop_ids = $this->argument('shop_id');
        $shops = $shop_ids ? Shop::whereIn('id', $shop_ids)->get() : Shop::all() ;
        $shops->each(function($shop) use ($report) {
            $report->build($shop->id);
            Analytics::create(['shop_id' => $shop->id, 'data' => $report->getValues()]);
        });

        return 0;
    }
}
