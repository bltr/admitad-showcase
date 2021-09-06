<?php


namespace App\Services\Analytics;


interface Report
{
    public function __construct(string $base_view);

    public function build(int $shopId);

    public function render(): string;

    public function getValues(): array;

    public function setValues(array $values): void;
}
