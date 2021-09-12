<?php


namespace App\Services\Catalog\Analytics;


use App\Models\Analytics;
use App\Models\Shop;
use App\Services\Analytics\CompositeReport;
use Illuminate\Support\Collection;

class AnalyticsService
{
    private function createReport(): CompositeReport
    {
        $composite = new CompositeReport();
        $composite->addReport(new OffersCountReport());
        $composite->addReport(new ShopsCountReport());

        return $composite;
    }

    public function build(): void
    {
        $report = $this->createReport();
        $report->build();
        Analytics::create(['data' => $report->getValues()]);
    }

    public function renderLastReport(): ?string
    {
        $analytics = Analytics::whereNull('shop_id')->latest()->first();
        $view = null;

        if ($analytics) {
            $report = $this->createReport();
            $report->setDate($analytics->created_at);
            $report->setValues($analytics->data);
            $view = $report->render();
        }

        return $view;
    }
}
