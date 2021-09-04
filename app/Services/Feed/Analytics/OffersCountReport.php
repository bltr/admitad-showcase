<?php


namespace App\Services\Feed\Analytics;


use App\Models\FeedOffer;
use App\Services\Analytics\AbstractReport;

class OffersCountReport extends AbstractReport
{
    protected array $values = [
        'count' => null,
        'invalid_count' => null,
    ];

    protected string $view = 'admin.feeds.analytics.';

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
