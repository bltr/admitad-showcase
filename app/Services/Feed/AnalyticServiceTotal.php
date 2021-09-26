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

    public function build(int $object_id = null): void
    {
        $report = $this->createReport();
        Analytics::create([
            'object_id' => $object_id,
            'data' => $report->build($object_id),
            'code' => $report->code()
        ]);
    }

    public function getLastReport(int $object_id = null): ?Analytics
    {
        $report = $this->createReport($object_id);

        return Analytics::where('object_id', $object_id)
            ->where('code', $report->code())
            ->latest()
            ->first();
    }
}
