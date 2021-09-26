<?php

namespace App\Services\Feed\AnalyticsReports;

use App\Models\FeedOffer;
use App\Services\Analytics\AbstractReport;

class TotalOffersCountReport extends AbstractReport
{
    public const CODE = 'feed.total_offers_count';

    protected array $values = [
        'count' => null,
    ];

    public function build(): array
    {
        $this->values['count'] = FeedOffer::count();

        return $this->values;
    }
}
