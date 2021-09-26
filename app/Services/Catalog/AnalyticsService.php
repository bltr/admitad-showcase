<?php


namespace App\Services\Catalog;


use App\Models\Analytics;
use App\Services\Analytics\CompositeReport;
use App\Services\Catalog\AnalyticsReports\OffersCountReport;
use App\Services\Catalog\AnalyticsReports\ShopsCountReport;

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
        Analytics::create(['data' => $report->getValues(), 'code' => $report->code()]);
    }

    public function getLastReport(): ?Analytics
    {
        $report = $this->createReport();

        return Analytics::where('code', $report->code())
            ->latest()
            ->first();
    }
}
