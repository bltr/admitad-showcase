<?php

namespace App\Services\Report;

use App\Models\Report;

class ReportService
{
    public function build(CompositeReport $report, int $object_id = null): void
    {
        Report::create([
            'object_id' => $object_id,
            'data' => $report->build($object_id),
            'code' => $report->code,
        ]);
    }

    public function getLastReport(CompositeReport $report, int $object_id = null): ?Report
    {
        return Report::where('object_id', $object_id)
            ->where('code', $report->code)
            ->latest()
            ->first();
    }
}
