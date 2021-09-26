<?php


namespace App\Services\Report\Reports;


use App\Models\FeedOffer;
use App\Services\Report\AbstractReport;

class FeedGroupsCountReport extends AbstractReport
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

    public function build(int $object_id = null): array
    {
        $this->values['group_id_count'] = FeedOffer::where('shop_id', $object_id)->distinct('data->group_id')->count();
        $this->values['url_count'] = FeedOffer::where('shop_id', $object_id)->distinct('data->url')->count();
        $this->values['picture_count'] = FeedOffer::where('shop_id', $object_id)
            ->selectRaw("count(distinct data #>> '{pictures, 0}') as count")
            ->value('count');

        if ($this->values['group_id_count'] !== 0) {
            $this->values['deviations']['group_id_deviation_in_picture_group'] = FeedOffer::where('shop_id', $object_id)
                ->groupByRaw("data #>> '{pictures, 0}'")
                ->havingRaw("count(distinct data ->> 'group_id') > 1")
                ->selectRaw('json_agg(id) as ids')
                ->withCasts(['ids' => 'array'])
                ->pluck('ids');

            $this->values['deviations']['group_id_deviation_in_url_group'] = FeedOffer::where('shop_id', $object_id)
                ->groupByRaw("data ->> 'url'")
                ->havingRaw("count(distinct data ->> 'group_id') > 1")
                ->selectRaw('json_agg(id) as ids')
                ->withCasts(['ids' => 'array'])
                ->pluck('ids');

            $this->values['deviations']['picture_deviation_in_group_id_group'] = FeedOffer::where('shop_id', $object_id)
                ->groupByRaw("data ->> 'group_id'")
                ->havingRaw("count(distinct data #>> '{pictures, 0}') > 1")
                ->selectRaw('json_agg(id) as ids')
                ->withCasts(['ids' => 'array'])
                ->pluck('ids');

            $this->values['deviations']['url_deviation_in_group_id_group'] = FeedOffer::where('shop_id', $object_id)
                ->groupByRaw("data ->> 'group_id'")
                ->havingRaw("count(distinct data ->> 'url') > 1")
                ->selectRaw('json_agg(id) as ids')
                ->withCasts(['ids' => 'array'])
                ->pluck('ids');
        }

        $this->values['deviations']['url_deviation_in_picture_group'] = FeedOffer::where('shop_id', $object_id)
            ->groupByRaw("data #>> '{pictures, 0}'")
            ->havingRaw("count(distinct data ->> 'url') > 1")
            ->selectRaw('json_agg(id) as ids')
            ->withCasts(['ids' => 'array'])
            ->pluck('ids');

        $this->values['deviations']['picture_deviation_in_url_group'] = FeedOffer::where('shop_id', $object_id)
            ->groupByRaw("data ->> 'url'")
            ->havingRaw("count(distinct data #>> '{pictures, 0}') > 1")
            ->selectRaw('json_agg(id) as ids')
            ->withCasts(['ids' => 'array'])
            ->pluck('ids');

        return $this->values;
    }
}
