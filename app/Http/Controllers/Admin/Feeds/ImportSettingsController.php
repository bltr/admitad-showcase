<?php

namespace App\Http\Controllers\Admin\Feeds;

use App\Models\FeedOffer;
use App\Services\PrecomputedValues\PrecomputedValuesService;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ImportSettingsController extends Controller
{
    public function index(Shop $shop, PrecomputedValuesService $computingService)
    {
        $values = $computingService->getLastValuesForShop($shop->id);

        return view('admin.feeds.import-settings', compact('shop') + $values);
    }

    public function groupDeviation(Shop $shop, Request $request, PrecomputedValuesService $computingService)
    {
        $values = $computingService->getLastValuesForShop($shop->id);

        $paginator = $this->getPaginator($values['feed_offers_group_deviations'][$request->deviation_type], $request);
        $offers = $this->getOffers($paginator->items());

        return view('admin.feeds.group-deviation', compact('shop', 'offers', 'paginator') + $values);
    }

    public function getPaginator(array $deviations, Request $request): LengthAwarePaginator
    {
        $deviations = collect($deviations);
        $page = (Paginator::resolveCurrentPage() ?: 1);
        $paginator = new LengthAwarePaginator(
            $deviations->forPage($page, 5),
            $deviations->count(),
            5,
            $page,
            ['path' => $request->fullUrl()]
        );

        return $paginator;
    }

    public function getOffers(array $ids_groups): Collection
    {
        $offer_ids = Arr::flatten($ids_groups);
        $offers = FeedOffer::selectRaw('*, jsonb_pretty(data) as data')
            ->whereIn('id', $offer_ids)
            ->get(['id', 'data'])
            ->keyBy('id');

        return $offers;
    }
}
