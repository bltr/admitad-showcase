<?php


namespace App\Services\PrecomputedValues\Values;


use App\Models\Shop;
use App\Services\PrecomputedValues\Values\Value;

class ActiveShopsCount implements Value
{
    public const CODE = 'active_shops_count';

    public function calc()
    {
        return Shop::active()->count();
    }
}
