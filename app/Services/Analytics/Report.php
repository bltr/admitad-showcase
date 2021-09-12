<?php


namespace App\Services\Analytics;


interface Report
{
    public function build();

    public function render(): string;

    public function getValues(): array;

    public function setValues(array $values): void;
}
