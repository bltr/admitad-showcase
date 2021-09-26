<?php

namespace App\Services\Report\Reports;

use App\Models\FeedOffer;
use App\Services\Report\AbstractReport;

class TotalFeedOffersCountReport extends AbstractReport
{
    public const CODE = 'feed.total_offers_count';

    protected array $values = [
        'count' => null,
    ];

    public function build(int $object_id = null): array
    {
        $this->values['count'] = FeedOffer::count();

        return $this->values;
    }
}
