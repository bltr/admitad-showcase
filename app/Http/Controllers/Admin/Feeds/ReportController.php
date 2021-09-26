<?php

namespace App\Http\Controllers\Admin\Feeds;

use App\Services\Report\ReportService;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Services\Report\CompositeReport;

class ReportController extends Controller
{
    public function index(Shop $shop, ReportService $reportService)
    {
        $report = $reportService->getLastReport(CompositeReport::feedReportByShop(), $shop->id);
        $shops = Shop::all();
        $currentShop = $shop;

        return view('admin.feeds.report', compact('currentShop', 'report', 'shops', 'shop'));
    }
}
