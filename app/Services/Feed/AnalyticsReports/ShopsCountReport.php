<?php

namespace App\Services\Feed\AnalyticsReports;

use App\Models\Shop;
use App\Services\Analytics\AbstractReport;

class ShopsCountReport extends AbstractReport
{
    public const CODE = 'feed.shops_count';

    protected array $values = [
        'count' => null,
    ];

    public function build(): array
    {
        $this->values['count'] = Shop::count();

        return $this->values;
    }
}
