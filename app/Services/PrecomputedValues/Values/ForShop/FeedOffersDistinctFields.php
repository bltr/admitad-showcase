<?php

namespace App\Services\PrecomputedValues\Values\ForShop;

use App\Models\FeedOffer;
use App\Services\PrecomputedValues\Values\Value;

class FeedOffersDistinctFields implements Value
{
    public const CODE = 'feed_offers_distinct_fields';

    protected int $shop_id;

    public function __construct(int $shop_id)
    {
        $this->shop_id = $shop_id;
    }

    public function calc()
    {
        return FeedOffer::distinct()
            ->fromSub(
                FeedOffer::selectRaw('jsonb_object_keys(data) AS field')->where('shop_id', $this->shop_id),
                'subquery'
            )->pluck('field');
    }
}
