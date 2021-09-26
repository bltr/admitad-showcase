<?php


namespace App\Services\Analytics;


use App\Services\Analytics\Reports\OffersCountReport;
use App\Services\Analytics\Reports\ShopsCountReport;
use App\Services\Analytics\Reports\FeedGroupsCountReport;
use App\Services\Analytics\Reports\FeedOffersCountReport;
use App\Services\Analytics\Reports\FeedShopsCountReport;
use App\Services\Analytics\Reports\TotalFeedOffersCountReport;

class CompositeReport implements Report
{
    public string $code = '';

    /**
     * @var array|AbstractReport[]
     */
    private array $reports = [];

    private function __construct(string $code)
    {
        $this->code = $code;
    }

    public static function feedReportByShop(): self
    {
        $composite = new self('feed_report_by_shop');
        $composite->addReport(new FeedOffersCountReport());
        $composite->addReport(new FeedGroupsCountReport());

        return $composite;
    }

    public static function feedReportTotal(): self
    {
        $report = new self('feed_report_total');
        $report->addReport(new TotalFeedOffersCountReport());
        $report->addReport(new FeedShopsCountReport());

        return $report;
    }

    public static function catalogReportTotal(): self
    {
        $report = new self('catalog_report_total');
        $report->addReport(new OffersCountReport());
        $report->addReport(new ShopsCountReport());

        return $report;
    }

    public function addReport(AbstractReport $report): void
    {
        $this->reports[$report::CODE] = $report;
    }

    public function build(int $object_id = null): array
    {
        $state = [];
        foreach ($this->reports as $code => $report) {
            $state[$code] = $report->build($object_id);
        }

        return $state;
    }
}
