<?php


namespace App\Services\Feed\Analytics;


use App\Services\Analytics\CompositeReport;
use App\Services\Analytics\Report;

class CompositeReportFactory
{
    private $base_view =  'admin.feeds.analytics';

    private $reports = [
        OffersCountReport::class,
        CountGroupsReport::class,
    ];

    public function build(): Report
    {
        $composite = new CompositeReport($this->base_view);
        foreach ($this->reports as $reportClassName) {
            $report = new $reportClassName($this->base_view);
            $composite->addReport($report);
        };

        return $composite;
    }
}
