<?php

namespace App\Services\PrecomputedValues\Values;

use App\Models\Shop;
use App\Services\PrecomputedValues\Values\Value;

class TotalShopsCount implements Value
{
    public const CODE = 'total_shops_count';

    public function calc(int $object_id = null)
    {
        return Shop::count();
    }
}
