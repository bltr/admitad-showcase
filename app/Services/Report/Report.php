<?php


namespace App\Services\Report;


interface Report
{
    public function build(int $object_id = null): array;
}
