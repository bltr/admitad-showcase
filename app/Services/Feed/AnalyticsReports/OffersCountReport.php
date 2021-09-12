<?php


namespace App\Services\Feed\AnalyticsReports;


use App\Models\FeedOffer;
use App\Services\Analytics\AbstractReport;

class OffersCountReport extends AbstractReport
{
    public const CODE = 'feed.offers_count';

    protected array $values = [
        'count' => null,
        'invalid_count' => null,
    ];

    private int $shopId;

    /**
     * @param int $shopId
     */
    public function __construct(int $shopId)
    {
        parent::__construct();
        $this->shopId = $shopId;
    }

    public function build()
    {
        $this->values['count'] = FeedOffer::where('shop_id', $this->shopId)->count();
        $this->values['invalid_count'] = FeedOffer::where('shop_id', $this->shopId)
            ->whereNull('data->price')
            ->orWhereRaw("data -> 'pictures' = '[]'::jsonb")
            ->orWhereNull('data->url')
            ->count();
    }
}
