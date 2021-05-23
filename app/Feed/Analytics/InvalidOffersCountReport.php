<?php


namespace App\Feed\Analytics;


use App\Models\Feed\Offers;

class InvalidOffersCountReport extends AbstractReport
{
    protected string $lable = 'Количество не валидных offers';

    protected string $desc = 'offers без цены, фото и ссылки';

    protected array $values = [
        'count' => null,
    ];

    public function build(int $shopId)
    {
        $this->values['count'] = Offers::where('shop_id', $shopId)
            ->whereNull('data->price')
            ->orWhereNull('data->picture')
            ->orWhereNull('data->url')
            ->count();
    }
}
