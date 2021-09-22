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

    public function render(): string
    {
        return view('admin._analytics.composite', ['reports' => $this->reports, 'date' => $this->date])->render();
    }

    public function getValues(): array
    {
        $state = [];
        foreach ($this->reports as $report) {
            $state[$report::CODE] = $report->getValues();
        }

        return $state;
    }

    public function setValues(array $values): void
    {
        foreach ($this->reports as $report) {
            $report->setValues($values[$report::CODE]);
        }
    }

    public function setDate(Carbon $date): void
    {
        $this->date = $date;
    }

    public function code()
    {
        return implode('#', array_map(fn($report) => $report::CODE, $this->reports));
    }
}
