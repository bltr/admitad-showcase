<?php


namespace App\Services\PrecomputedValues\Values\ForShop;


use App\Models\FeedOffer;
use App\Services\PrecomputedValues\Values\Value;

class FeedOffersGroupDeviations implements Value
{
    public const CODE = 'feed_offers_group_deviations';

    protected int $shop_id;

    public function __construct(int $shop_id)
    {
        $this->shop_id = $shop_id;
    }

    public function calc()
    {
        $values = [];
        $group_id_count = FeedOffer::where('shop_id', $this->shop_id)->distinct('data->group_id')->count();

        if ($group_id_count !== 0) {
            $values['group_id_deviation_in_picture_group'] = FeedOffer::where('shop_id', $this->shop_id)
                ->groupByRaw("data #>> '{pictures, 0}'")
                ->havingRaw("count(distinct data ->> 'group_id') > 1")
                ->selectRaw("json_agg(id) as ids, data #>> '{pictures, 0}' as picture")
                ->withCasts(['ids' => 'array'])
                ->pluck('ids', 'picture');

            $values['group_id_deviation_in_url_group'] = FeedOffer::where('shop_id', $this->shop_id)
                ->groupByRaw("data ->> 'url'")
                ->havingRaw("count(distinct data ->> 'group_id') > 1")
                ->selectRaw("json_agg(id) as ids, data ->> 'url' as url")
                ->withCasts(['ids' => 'array'])
                ->pluck('ids', 'url');

            $values['picture_deviation_in_group_id_group'] = FeedOffer::where('shop_id', $this->shop_id)
                ->groupByRaw("data ->> 'group_id'")
                ->havingRaw("count(distinct data #>> '{pictures, 0}') > 1")
                ->selectRaw("json_agg(id) as ids, data ->> 'group_id' as group_id")
                ->withCasts(['ids' => 'array'])
                ->pluck('ids', 'group_id');

            $values['url_deviation_in_group_id_group'] = FeedOffer::where('shop_id', $this->shop_id)
                ->groupByRaw("data ->> 'group_id'")
                ->havingRaw("count(distinct data ->> 'url') > 1")
                ->selectRaw("json_agg(id) as ids, data ->> 'group_id' as group_id")
                ->withCasts(['ids' => 'array'])
                ->pluck('ids', 'group_id');
        }

        $values['url_deviation_in_picture_group'] = FeedOffer::where('shop_id', $this->shop_id)
            ->groupByRaw("data #>> '{pictures, 0}'")
            ->havingRaw("count(distinct data ->> 'url') > 1")
            ->selectRaw("json_agg(id) as ids, data #>> '{pictures, 0}' as picture")
            ->withCasts(['ids' => 'array'])
            ->pluck('ids', 'picture');

        $values['picture_deviation_in_url_group'] = FeedOffer::where('shop_id', $this->shop_id)
            ->groupByRaw("data ->> 'url'")
            ->havingRaw("count(distinct data #>> '{pictures, 0}') > 1")
            ->selectRaw("json_agg(id) as ids, data ->> 'url' as url")
            ->withCasts(['ids' => 'array'])
            ->pluck('ids', 'url');

        return $values;
    }
}
