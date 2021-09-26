<?php

namespace App\Services\Report;

use App\Models\Reports;

class ReportService
{
    public function build(CompositeReport $report, int $object_id = null): void
    {
        Reports::create([
            'object_id' => $object_id,
            'data' => $report->build($object_id),
            'code' => $report->code,
        ]);
    }

    public function getLastReport(CompositeReport $report, int $object_id = null): ?Reports
    {
        return Reports::where('object_id', $object_id)
            ->where('code', $report->code)
            ->latest()
            ->first();
    }
}
