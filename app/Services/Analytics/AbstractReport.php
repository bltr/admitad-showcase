<?php


namespace App\Services\Analytics;


use Illuminate\Support\Str;

abstract class AbstractReport implements Report
{
    protected array $values = [];

    public function __construct()
    {
        if (empty($this->values)) {
            throw new \ErrorException('Is not defined values.');
        }
    }

    abstract public function build(int $shopId);

    public function render(): string
    {
        return view('admin.shops.feeds.analytics.reports.' . $this->getCode(), $this->getValues())->render();
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function setValues(array $values): void
    {
        $this->values = $values;
    }

    public function getCode(): string
    {
        return Str::replaceLast('_report', '', Str::snake(class_basename(static::class)));
    }
}
