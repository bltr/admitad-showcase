<?php


namespace App\Services\Feed;


use App\Models\Analytics;
use App\Models\Shop;
use App\Services\Analytics\CompositeReport;
use App\Services\Feed\AnalyticsReports\GroupsCountReport;
use App\Services\Feed\AnalyticsReports\OffersCountReport;

class AnalyticsServiceByShop
{
    private function createReport(int $shopId): CompositeReport
    {
        $composite = new CompositeReport();
        $composite->addReport(new OffersCountReport($shopId));
        $composite->addReport(new GroupsCountReport($shopId));

        return $composite;
    }

    public function build(Shop $shop): void
    {
        Analytics::create(['shop_id' => $shop->id ?? null, 'data' => $this->createReport($shop->id)->build(), 'code' => $this->createReport($shop->id)->code()]);
    }

    public function getLastReport(Shop $shop): ?Analytics
    {
        $report = $this->createReport($shop->id);

        return Analytics::where('shop_id', $shop->id)
            ->where('code', $report->code())
            ->latest()
            ->first();
    }
}
