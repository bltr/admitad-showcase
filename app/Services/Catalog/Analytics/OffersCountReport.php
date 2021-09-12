<?php


namespace App\Services\Catalog\Analytics;


use App\Models\Offer;
use App\Services\Analytics\AbstractReport;

class OffersCountReport extends AbstractReport
{
    public const CODE = 'catalog.offers_count';

    protected array $values = [
        'count' => null,
    ];

    public function build()
    {
        $this->values['count'] = Offer::count();
    }
}
