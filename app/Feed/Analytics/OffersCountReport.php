<?php


namespace App\Feed\Analytics;


use App\Models\Feed\Offers;

class OffersCountReport extends AbstractReport
{
    protected string $lable = 'Количество offers';

    protected string $desc = 'общее колличество включая не валидные';

    protected array $values = [
        'count' => null,
    ];

    public function build(int $shopId)
    {
        $this->values['count'] = Offers::where('shop_id', $shopId)->count();
    }
}
