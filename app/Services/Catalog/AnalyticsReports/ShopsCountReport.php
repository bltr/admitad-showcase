<?php


namespace App\Services\Catalog\AnalyticsReports;


use App\Models\Shop;
use App\Services\Analytics\AbstractReport;

class ShopsCountReport extends AbstractReport
{
    public const CODE = 'catalog.shops_count';

    protected array $values = [
        'count' => null,
    ];

    public function build()
    {
        $this->values['count'] = Shop::count();
    }
}
