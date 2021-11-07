<?php


namespace App\Services\PrecomputedValues\Values\ForShop;


use App\Models\FeedOffer;
use App\Services\PrecomputedValues\Values\Value;

class InvalidFeedOffersCount implements Value
{
    public const CODE = 'invalid_feed_offers_count';

    protected int $shop_id;

    public function __construct(int $shop_id)
    {
        $this->shop_id = $shop_id;
    }

    public function calc()
    {
        return FeedOffer::invalid()
            ->where('shop_id', $this->shop_id)
            ->count();
    }
}
