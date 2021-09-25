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
        $report = $this->createReport();
        $report->build();
        Analytics::create(['data' => $report->getValues(), 'code' => $report->code()]);
    }

    public function renderLastReport(): ?string
    {
        $report = $this->createReport();
        $analytics = Analytics::where('code', $report->code())
            ->latest()
            ->first();

        $view = null;
        if ($analytics) {
            $report->setDate($analytics->created_at);
            $report->setValues($analytics->data);
            $view = $report->render();
        }

        return $view;
    }
}
