<?php


namespace App\Services\Feed\Analytics;


use App\Services\Analytics\CompositeReport;
use App\Services\Analytics\Report;

class CompositeReportFactory
{
    public function build(): Report
    {
        $composite = new CompositeReport();
        $composite->addReport(new OffersCountReport());
        $composite->addReport(new CountGroupsReport());

        return $composite;
    }
}
