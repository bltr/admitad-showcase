<?php


namespace App\Services\Analytics;


use Illuminate\Support\Str;

abstract class AbstractReport implements Report
{
    protected array $values = [];

    protected string $view;

    public function __construct()
    {
        if (empty($this->values) && empty($this->view)) {
            throw new \ErrorException('Is not defined values or view.');
        }
    }

    abstract public function build(int $shopId);

    public function render(): string
    {
        return view($this->view . $this->getCode(), $this->getValues())->render();
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
