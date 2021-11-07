<?php

namespace App\Services\PrecomputedValues\Values;

use App\Models\FeedOffer;
use App\Services\PrecomputedValues\Values\Value;

class TotalFeedOffersCount implements Value
{
    public const CODE = 'total_feed_offers_count';

    public function calc()
    {
        return FeedOffer::count();
    }
}
