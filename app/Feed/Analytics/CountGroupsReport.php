<?php


namespace App\Feed\Analytics;


use App\Models\Feed\Offers;

class CountGroupsReport extends AbstractReport
{
    protected string $lable = 'Количество групп';

    protected string $desc = 'по group_id, url и picture';

    protected array $values = [
        'group_id_count' => null,
        'url_count' => null,
        'picture_count' => null,
    ];

    public function build(int $shopId)
    {
        $this->values['group_id_count'] = Offers::where('shop_id', $shopId)->distinct('data->group_id')->count();
        $this->values['url_count'] = Offers::where('shop_id', $shopId)->distinct('data->url')->count();
        $this->values['picture_count'] = Offers::where('shop_id', $shopId)->distinct('data->picture')->count();
    }
}
