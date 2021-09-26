<?php


namespace App\Services\Feed\AnalyticsReports;


use App\Models\FeedOffer;
use App\Services\Analytics\AbstractReport;
use Illuminate\Database\Eloquent\Builder;

class OffersCountReport extends AbstractReport
{
    public const CODE = 'feed.offers_count';

    protected array $values = [
        'count' => null,
        'invalid_count' => null,
    ];

    public function build(int $object_id = null): array
    {
        $this->values['count'] = FeedOffer::where('shop_id', $object_id)->count();
        $this->values['invalid_count'] = FeedOffer::where('shop_id', $object_id)
            ->where(fn($query) => $this->whereInvalidOffers($query))
            ->count();

        return $this->values;
    }

    protected function whereInvalidOffers(Builder $query): Builder
    {
        return $query->whereNull('data->price')
            ->orWhereRaw("data -> 'pictures' = '[]'::jsonb")
            ->orWhereNull('data->url');
    }
}
