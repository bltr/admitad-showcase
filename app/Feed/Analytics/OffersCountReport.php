<?php


namespace App\Feed\Analytics;


use App\Models\FeedOffer;

class OffersCountReport extends AbstractReport
{
    protected array $values = [
        'count' => null,
        'invalid_count' => null,
    ];

    public function build(int $shopId)
    {
        $this->values['count'] = FeedOffer::where('shop_id', $shopId)->count();
        $this->values['invalid_count'] = FeedOffer::where('shop_id', $shopId)
            ->whereNull('data->price')
            ->orWhereRaw("data -> 'pictures' = '[]'::jsonb")
            ->orWhereNull('data->url')
            ->count();
    }
}
