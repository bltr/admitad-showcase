<?php


namespace App\Services\Feed\Analytics;


use App\Models\FeedOffer;
use App\Services\Analytics\AbstractReport;

class CountGroupsReport extends AbstractReport
{
    protected array $values = [
        'group_id_count' => null,
        'url_count' => null,
        'picture_count' => null,
        'deviations' => [
            'group_id_picture' => null,
            'group_id_url' => null,
            'picture_group_id' => null,
            'picture_url' => null,
            'url_group_id' => null,
            'url_picture' => null,
        ]
    ];

    protected string $view = 'admin.feeds.analytics.';

    public function build(int $shopId)
    {
        $this->values['group_id_count'] = FeedOffer::where('shop_id', $shopId)->distinct('data->group_id')->count();
        $this->values['url_count'] = FeedOffer::where('shop_id', $shopId)->distinct('data->url')->count();
        $this->values['picture_count'] = FeedOffer::where('shop_id', $shopId)
            ->selectRaw("count(distinct data #>> '{pictures, 0}') as count")
            ->value('count');

        if ($this->values['group_id_count'] !== 0) {
            $this->values['deviations']['picture_group_id'] = FeedOffer::where('shop_id', $shopId)
                ->groupByRaw("data #>> '{pictures, 0}'")
                ->havingRaw("count(distinct data ->> 'group_id') > 1")
                ->selectRaw('json_agg(id) as ids')
                ->pluck('ids');
            $this->values['deviations']['url_group_id'] = FeedOffer::where('shop_id', $shopId)
                ->groupByRaw("data ->> 'url'")
                ->havingRaw("count(distinct data ->> 'group_id') > 1")
                ->selectRaw('json_agg(id) as ids')
                ->pluck('ids');
            $this->values['deviations']['group_id_picture'] = FeedOffer::where('shop_id', $shopId)
                ->groupByRaw("data ->> 'group_id'")
                ->havingRaw("count(distinct data #>> '{pictures, 0}') > 1")
                ->selectRaw('json_agg(id) as ids')
                ->pluck('ids');
            $this->values['deviations']['group_id_url'] = FeedOffer::where('shop_id', $shopId)
                ->groupByRaw("data ->> 'group_id'")
                ->havingRaw("count(distinct data ->> 'url') > 1")
                ->selectRaw('json_agg(id) as ids')
                ->pluck('ids');
        }

        $this->values['deviations']['picture_url'] = FeedOffer::where('shop_id', $shopId)
            ->groupByRaw("data #>> '{pictures, 0}'")
            ->havingRaw("count(distinct data ->> 'url') > 1")
            ->selectRaw('json_agg(id) as ids')
            ->pluck('ids');

        $this->values['deviations']['url_picture'] = FeedOffer::where('shop_id', $shopId)
            ->groupByRaw("data ->> 'url'")
            ->havingRaw("count(distinct data #>> '{pictures, 0}') > 1")
            ->selectRaw('json_agg(id) as ids')
            ->pluck('ids');
    }
}
