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
        $compositeReport = CompositeReport::feedReportByShop();
        $report = $reportService->getLastReport($compositeReport, $shop->id);
        $reports_codes = $compositeReport->getReportsCodes();
        $shops = Shop::all();
        $currentShop = $shop;

        return view('admin.feeds.report', compact('currentShop', 'report', 'reports_codes', 'shops', 'shop'));
    }

    public function groupDeviation(Shop $shop, Report $report, Request $request)
    {
        $paginator = $this->getPaginator($report->data['feed.groups_count']['deviations'][$request->deviation_type], $request);
        $offers = $this->getOffers($paginator->items());

        return view('admin.feeds.group-deviation', compact('shop', 'report', 'offers', 'paginator'));
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
