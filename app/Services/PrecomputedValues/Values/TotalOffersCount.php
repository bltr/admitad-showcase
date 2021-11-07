<?php


namespace App\Services\PrecomputedValues\Values;


use App\Models\Offer;
use App\Services\PrecomputedValues\Values\Value;

class TotalOffersCount implements Value
{
    public const CODE = 'total_offers_count';

    public function calc()
    {
        return Offer::count();
    }
}
