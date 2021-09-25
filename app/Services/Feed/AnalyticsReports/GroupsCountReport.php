<?php


namespace App\Services\Feed\AnalyticsReports;


use App\Models\FeedOffer;
use App\Services\Analytics\AbstractReport;

class GroupsCountReport extends AbstractReport
{
    public const CODE = 'feed.groups_count';

    protected array $values = [
        'group_id_count' => null,
        'url_count' => null,
        'picture_count' => null,
        'deviations' => [
            'picture_deviation_in_group_id_group' => null,
            'url_deviation_in_group_id_group' => null,
            'group_id_deviation_in_picture_group' => null,
            'url_deviation_in_picture_group' => null,
            'group_id_deviation_in_url_group' => null,
            'picture_deviation_in_url_group' => null,
        ]
    ];

    private int $shopId;

    /**
     * @param int $shopId
     */
    public function __construct(int $shopId)
    {
        parent::__construct();
        $this->shopId = $shopId;
    }

    public function build()
    {
        $this->values['group_id_count'] = FeedOffer::where('shop_id', $this->shopId)->distinct('data->group_id')->count();
        $this->values['url_count'] = FeedOffer::where('shop_id', $this->shopId)->distinct('data->url')->count();
        $this->values['picture_count'] = FeedOffer::where('shop_id', $this->shopId)
            ->selectRaw("count(distinct data #>> '{pictures, 0}') as count")
            ->value('count');

        if ($this->values['group_id_count'] !== 0) {
            $this->values['deviations']['group_id_deviation_in_picture_group'] = FeedOffer::where('shop_id', $this->shopId)
                ->groupByRaw("data #>> '{pictures, 0}'")
                ->havingRaw("count(distinct data ->> 'group_id') > 1")
                ->selectRaw('json_agg(id) as ids')
                ->withCasts(['ids' => 'array'])
                ->pluck('ids');

            $this->values['deviations']['group_id_deviation_in_url_group'] = FeedOffer::where('shop_id', $this->shopId)
                ->groupByRaw("data ->> 'url'")
                ->havingRaw("count(distinct data ->> 'group_id') > 1")
                ->selectRaw('json_agg(id) as ids')
                ->withCasts(['ids' => 'array'])
                ->pluck('ids');

            $this->values['deviations']['picture_deviation_in_group_id_group'] = FeedOffer::where('shop_id', $this->shopId)
                ->groupByRaw("data ->> 'group_id'")
                ->havingRaw("count(distinct data #>> '{pictures, 0}') > 1")
                ->selectRaw('json_agg(id) as ids')
                ->withCasts(['ids' => 'array'])
                ->pluck('ids');

            $this->values['deviations']['url_deviation_in_group_id_group'] = FeedOffer::where('shop_id', $this->shopId)
                ->groupByRaw("data ->> 'group_id'")
                ->havingRaw("count(distinct data ->> 'url') > 1")
                ->selectRaw('json_agg(id) as ids')
                ->withCasts(['ids' => 'array'])
                ->pluck('ids');
        }

        $this->values['deviations']['url_deviation_in_picture_group'] = FeedOffer::where('shop_id', $this->shopId)
            ->groupByRaw("data #>> '{pictures, 0}'")
            ->havingRaw("count(distinct data ->> 'url') > 1")
            ->selectRaw('json_agg(id) as ids')
            ->withCasts(['ids' => 'array'])
            ->pluck('ids');

        $this->values['deviations']['picture_deviation_in_url_group'] = FeedOffer::where('shop_id', $this->shopId)
            ->groupByRaw("data ->> 'url'")
            ->havingRaw("count(distinct data #>> '{pictures, 0}') > 1")
            ->selectRaw('json_agg(id) as ids')
            ->withCasts(['ids' => 'array'])
            ->pluck('ids');
    }
}
