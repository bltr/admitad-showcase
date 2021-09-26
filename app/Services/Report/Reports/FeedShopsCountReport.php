<?php

namespace App\Services\Report\Reports;

use App\Models\Shop;
use App\Services\Report\AbstractReport;

class FeedShopsCountReport extends AbstractReport
{
    public const CODE = 'feed.shops_count';

    protected array $values = [
        'count' => null,
    ];

    public function build(int $object_id = null): array
    {
        $this->values['count'] = Shop::count();

        return $this->values;
    }
}
