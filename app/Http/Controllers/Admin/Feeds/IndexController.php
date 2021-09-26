<?php

namespace App\Http\Controllers\Admin\Feeds;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Services\Report\ReportService;
use App\Services\Report\CompositeReport;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(ReportService $reportService)
    {
        $shops = Shop::with('report')->get();
        $report = $reportService->getLastReport(CompositeReport::feedReportTotal());

        return view('admin.feeds.index', compact('shops', 'report'));
    }

    public function toggleActivity(Shop $shop)
    {
        $shop->toggleActivity();

        return back();
    }

    public function importType(Shop $shop, Request $request)
    {
        $shop->import_type = $request->import_type;
        $shop->save();

        return back();
    }
}
