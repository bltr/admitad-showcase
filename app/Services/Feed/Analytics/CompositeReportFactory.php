<?php


namespace App\Services\Feed\Analytics;


use App\Services\Analytics\CompositeReport;
use App\Services\Analytics\Report;

class CompositeReportFactory
{
    private $base_view =  'admin.feeds.analytics';

    public function build(): Report
    {
        $composite = new CompositeReport($this->base_view);
        $composite->addReport(new OffersCountReport($this->base_view));
        $composite->addReport(new CountGroupsReport($this->base_view));

        return $composite;
    }
}
