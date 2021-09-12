<?php


namespace App\Services\Feed\Analytics;


use App\Models\Analytics;
use App\Models\Shop;
use App\Services\Analytics\CompositeReport;
use Illuminate\Support\Collection;

class AnalyticsService
{
    private function createReport(int $shopId): CompositeReport
    {
        $composite = new CompositeReport();
        $composite->addReport(new OffersCountReport($shopId));
        $composite->addReport(new CountGroupsReport($shopId));

        return $composite;
    }

    /**
     * @param Collection|Shop[] $shops
     */
    public function build(Collection $shops): void
    {
        $shops->each(function($shop) {
            $report = $this->createReport($shop->id);
            $report->build();
            Analytics::create(['shop_id' => $shop->id, 'data' => $report->getValues()]);
        });
    }

    public function renderLastReport(Shop $shop): string
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
