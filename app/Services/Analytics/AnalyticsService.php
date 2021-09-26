<?php

namespace App\Services\Analytics;

use App\Models\Analytics;

class AnalyticsService
{
    public function build(CompositeReport $report, int $object_id = null): void
    {
        Analytics::create([
            'object_id' => $object_id,
            'data' => $report->build($object_id),
            'code' => $report->code,
        ]);
    }

    public function getLastReport(CompositeReport $report, int $object_id = null): ?Analytics
    {
        return Analytics::where('object_id', $object_id)
            ->where('code', $report->code)
            ->latest()
            ->first();
    }
}
