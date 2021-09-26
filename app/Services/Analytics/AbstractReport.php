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

    public function getValues(): array
    {
        return $this->values;
    }
}
