<?php


namespace App\Feed\Analytics;


interface Report
{
    public function build(int $shopId);

    public function render(): string;

    public function getValues(): array;

    public function setValues(array $values): void;
}
