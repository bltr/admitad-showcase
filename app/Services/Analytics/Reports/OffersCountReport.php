<?php


namespace App\Services\Analytics\Reports;


use App\Models\Offer;
use App\Services\Analytics\AbstractReport;

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
