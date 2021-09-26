<?php


namespace App\Services\Report\Reports;


use App\Models\Offer;
use App\Services\Report\AbstractReport;

class OffersCountReport extends AbstractReport
{
    public const CODE = 'catalog.offers_count';

    protected array $values = [
        'count' => null,
    ];

    public function build(int $object_id = null): array
    {
        $this->values['count'] = Offer::count();

        return $this->values;
    }
}
