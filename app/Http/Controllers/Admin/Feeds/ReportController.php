<?php

namespace App\Http\Controllers\Admin\Feeds;

use App\Models\FeedOffer;
use App\Models\Report;
use App\Services\Report\ReportService;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Services\Report\CompositeReport;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ReportController extends Controller
{
    public function index(Shop $shop, ReportService $reportService)
    {
        $report = $reportService->getLastReport(CompositeReport::feedReportByShop(), $shop->id);
        $shops = Shop::all();
        $currentShop = $shop;

        return view('admin.feeds.report', compact('currentShop', 'report', 'shops', 'shop'));
    }

    public function groupDeviation(Shop $shop, Report $report, Request $request)
    {
        $deviation_type = $request->deviation_type;
        $paginator = $this->getPaginator($report->data['feed.groups_count']['deviations'][$deviation_type], $request);
        $offer_ids_groups = $paginator->items();
        $offers = $this->getOffers($offer_ids_groups);

        return view('admin.feeds.group-deviation', compact('shop', 'report', 'offers', 'deviation_type', 'paginator'));
    }

    public function getPaginator($deviations, Request $request): LengthAwarePaginator
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
