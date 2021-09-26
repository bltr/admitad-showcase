<?php


namespace App\Services\Analytics;


interface Report
{
    public function build();

    public function getValues(): array;
}
