<?php

namespace App\Http\Controllers\Admin\Feeds;

use App\Models\FeedOffer;
use App\Models\ImportMapping;
use App\Services\PrecomputedValues\PrecomputedValuesService;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Services\PrecomputedValues\Values\ForShop\FeedOffersDistinctFields;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class ImportSettingsController extends Controller
{
    public function grouping(Shop $shop, PrecomputedValuesService $computingService, Request $request)
    {
        $values = $computingService->getLastValuesForShop($shop->id);

        $paginator = null;
        $offers = null;
        if ($request->filled('deviation_type')) {
            $paginator = $this->getPaginator($values['feed_offers_group_deviations'][$request->deviation_type], $request);
            $offers = $this->getOffers($paginator->items());
        }

        return view('admin.feeds.import-grouping', compact('shop', 'offers', 'paginator') + $values);
    }

    public function setGrouping(Shop $shop, Request $request)
    {
        $request->validate(['import_type' => 'in:' . implode(',', $shop->getImportGroupings())]);
        $shop->setImportGrouping($request->import_type);

        return back();
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

    public function getOffers(array $idsGroups): Collection
    {
        $offerIds = Arr::flatten($idsGroups);
        $offers = FeedOffer::selectRaw('*, jsonb_pretty(data) as data')
            ->whereIn('id', $offerIds)
            ->get(['id', 'data'])
            ->keyBy('id');

        return $offers;
    }

    public function mapping(Shop $shop, PrecomputedValuesService $computingService, Request $request)
    {
        $feedOffersDistinctFields = $computingService->getLastValueForShop($shop->id, FeedOffersDistinctFields::CODE);

        $feedOffers = $shop->feed_offers()
            ->with('feed_category')
            ->when(!$request->field, fn($query) => $query->selectRaw('jsonb_pretty(data) as data'))
            ->when($request->field, function($query, $field) {
                if (!in_array($field, ['full_category_name', 'category_name'])) {
                    $query->selectRaw("data ->> '$field' as data");
                }
            })
            ->simplePaginate()
            ->withQueryString();

        return view('admin.feeds.import-mapping', compact('shop', 'feedOffersDistinctFields', 'feedOffers'));
    }

    public function setMapping(Shop $shop, Request $request)
    {
        $data = $request->collect()
            ->filter(fn($value) => in_array($value, array_keys(Shop::IMPORT_MAPPING_TARGET_FIELDS)))
            ->mapToDictionary(fn($targetField, $field) => [$targetField => $field])
            ->all();

        $shop->setImportMapping($data);

        return back();
    }
}
