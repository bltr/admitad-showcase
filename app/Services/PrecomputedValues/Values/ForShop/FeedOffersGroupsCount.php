<?php


namespace App\Services\PrecomputedValues\Values\ForShop;


use App\Models\FeedOffer;
use App\Services\PrecomputedValues\Values\Value;

class FeedOffersGroupsCount implements Value
{
    public const CODE = 'feed_offers_groups_count';

    protected int $shop_id;

    public function __construct(int $shop_id)
    {
        $this->shop_id = $shop_id;
    }

    protected array $values = [
        'group_id_count' => null,
        'url_count' => null,
        'picture_count' => null,
    ];

    public function calc()
    {
        $values = [];

        $values['group_id_count'] = FeedOffer::where('shop_id', $this->shop_id)->distinct('data->group_id')->count();
        $values['url_count'] = FeedOffer::where('shop_id', $this->shop_id)->distinct('data->url')->count();
        $values['picture_count'] = FeedOffer::where('shop_id', $this->shop_id)
            ->selectRaw("count(distinct data #>> '{pictures, 0}') as count")
            ->value('count');

        return $values;
    }
}
