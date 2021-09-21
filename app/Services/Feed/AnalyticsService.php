<?php


namespace App\Services\Feed;


use App\Models\Analytics;
use App\Models\Shop;
use App\Services\Analytics\CompositeReport;
use App\Services\Feed\AnalyticsReports\GroupsCountReport;
use App\Services\Feed\AnalyticsReports\OffersCountReport;

class AnalyticsService
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
        $report = $this->createReport($shop->id);
        $report->build();
        Analytics::create(['shop_id' => $shop->id, 'data' => $report->getValues()]);
    }

    public function renderLastReport(Shop $shop): ?string
    {
        $analytics = Analytics::where('shop_id', $shop->id)->latest()->first();
        $view = null;

        if ($analytics) {
            $report = $this->createReport($shop->id);
            $report->setDate($analytics->created_at);
            $report->setValues($analytics->data);
            $view = $report->render();
        }

        return $view;
    }
}
