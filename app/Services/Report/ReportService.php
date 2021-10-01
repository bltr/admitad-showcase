<?php

namespace App\Services\Report;

use App\Models\Report;

class ReportService
{
    const LAST_REPORTS_COUNT = 2;

    public function build(CompositeReport $report, int $object_id = null): void
    {
        Report::create([
            'object_id' => $object_id,
            'data' => $report->build($object_id),
            'code' => $report->code,
        ]);

        $last_report_ids = Report::where('object_id', $object_id)
            ->where('code', $report->code)
            ->latest()
            ->limit(self::LAST_REPORTS_COUNT)
            ->pluck('id');

        Report::where('object_id', $object_id)
            ->where('code', $report->code)
            ->whereNotIn('id', $last_report_ids)
            ->delete();
    }

    public function getLastReport(CompositeReport $report, int $object_id = null): ?Report
    {
        return Report::where('object_id', $object_id)
            ->where('code', $report->code)
            ->latest()
            ->first();
    }
}
