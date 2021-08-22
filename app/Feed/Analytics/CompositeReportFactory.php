<?php


namespace App\Feed\Analytics;


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
