<?php


namespace App\Services\Analytics;


interface Report
{
    public function build(int $object_id = null): array;
}
