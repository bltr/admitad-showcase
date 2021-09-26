<?php


namespace App\Services\Analytics;


use Illuminate\Support\Carbon;

class CompositeReport implements Report
{
    /**
     * @var array|AbstractReport[]
     */
    private array $reports;

    private Carbon $date;

    public function addReport(AbstractReport $report): void
    {
        $this->reports[$report::CODE] = $report;
    }

    public function build(): void
    {
        foreach ($this->reports as $report) {
            $report->build();
        }
    }

    public function getValues(): array
    {
        $state = [];
        foreach ($this->reports as $report) {
            $state[$report::CODE] = $report->getValues();
        }

        return $state;
    }

    public function code()
    {
        return implode('#', array_map(fn($report) => $report::CODE, $this->reports));
    }
}
