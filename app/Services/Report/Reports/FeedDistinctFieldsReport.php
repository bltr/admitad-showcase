<?php

namespace App\Services\Report\Reports;

use App\Models\FeedOffer;
use App\Services\Report\AbstractReport;

class FeedDistinctFieldsReport extends AbstractReport
{
    public const CODE = 'feed.distinct_offers_fields';

    protected array $values = [
        'fields' => [],
    ];

    public function build(int $object_id = null): array
    {
        $this->values['fields'] = FeedOffer::distinct()
            ->fromSub(
                FeedOffer::selectRaw('jsonb_object_keys(data) AS field')->where('shop_id', $object_id),
                's'
            )->pluck('field');

        return $this->values;
    }
}
