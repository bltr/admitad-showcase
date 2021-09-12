<?php


namespace App\Services\Analytics;


abstract class AbstractReport implements Report
{
    public const CODE = '';

    protected array $values = [];

    public function __construct()
    {
        if (empty($this->values) || empty(static::CODE)) {
            throw new \ErrorException('Is not defined values or code.');
        }
    }

    abstract public function build();

    public function render(): string
    {
        return view('admin._analytics.' . static::CODE, $this->getValues())->render();
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function setValues(array $values): void
    {
        $this->values = $values;
    }
}
