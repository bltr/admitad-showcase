<?php


namespace App\Services\Analytics;


class CompositeReport implements Report
{
    /**
     * @var array|AbstractReport[]
     */
    private array $reports;

    public function addReport(AbstractReport $report): void
    {
        $this->reports[$report::CODE] = $report;
    }

    public function build(): array
    {
        $state = [];
        foreach ($this->reports as $code => $report) {
            $state[$code] = $report->build();
        }

        return $state;
    }

    public function code()
    {
        return implode('#', array_map(fn($report) => $report::CODE, $this->reports));
    }
}
