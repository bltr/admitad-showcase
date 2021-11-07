<?php


namespace App\Services\PrecomputedValues\Values\ForShop;


use App\Models\FeedOffer;
use App\Services\PrecomputedValues\Values\Value;

class FeedOffersCount implements Value
{
    public const CODE = 'feed_offers_count';

    protected int $shop_id;

    public function __construct(int $shop_id)
    {
        $this->shop_id = $shop_id;
    }

    public function calc()
    {
        return FeedOffer::where('shop_id', $this->shop_id)->count();
    }
}
