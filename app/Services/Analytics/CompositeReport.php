<?php


namespace App\Services\Analytics;


class CompositeReport implements Report
{
    /**
     * @var array|AbstractReport[]
     */
    private array $reports;

    public function addReport(AbstractReport $report)
    {
        $this->reports[$report->getCode()] = $report;
    }

    public function build(int $shopId)
    {
        foreach ($this->reports as $report) {
            $report->build($shopId);
        }
    }

    public function render(): string
    {
        return view('admin._analytics.composite', ['reports' => $this->reports])->render();
    }

    public function getValues(): array
    {
        $state = [];
        foreach ($this->reports as $report) {
            $state[$report->getCode()] = $report->getValues();
        }

        return $state;
    }

    public function setValues(array $values): void
    {
        foreach ($this->reports as $report) {
            $report->setValues($values[$report->getCode()]);
        }
    }
}
