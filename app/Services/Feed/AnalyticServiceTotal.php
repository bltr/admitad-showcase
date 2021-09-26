<?php

namespace App\Services\Feed;

use App\Models\Analytics;
use App\Services\Analytics\CompositeReport;
use App\Services\Feed\AnalyticsReports\ShopsCountReport;
use App\Services\Feed\AnalyticsReports\TotalOffersCountReport;

class AnalyticServiceTotal
{
    private function createReport(): CompositeReport
    {
        $composite = new CompositeReport();
        $composite->addReport(new TotalOffersCountReport());
        $composite->addReport(new ShopsCountReport());

        return $composite;
    }

    public function build(): void
    {
        Analytics::create(['data' => $this->createReport()->build(), 'code' => $this->createReport()->code()]);
    }

    public function getLastReport(): ?Analytics
    {
        $report = $this->createReport();

        return Analytics::where('code', $report->code())
            ->latest()
            ->first();
    }
}
