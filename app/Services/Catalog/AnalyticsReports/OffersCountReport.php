<?php


namespace App\Services\Catalog\AnalyticsReports;


use App\Models\Offer;
use App\Services\Analytics\AbstractReport;

class OffersCountReport extends AbstractReport
{
    public const CODE = 'catalog.offers_count';

    protected array $values = [
        'count' => null,
    ];

    public function build(): array
    {
        $this->values['count'] = Offer::count();

        return $this->values;
    }
}
