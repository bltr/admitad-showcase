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
