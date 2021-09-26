<?php

namespace App\Http\Controllers\Admin\Feeds;

use App\Services\Analytics\AnalyticsService;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Services\Analytics\CompositeReport;

class AnalyticsController extends Controller
{
    public function index(Shop $shop, AnalyticsService $analyticsService)
    {
        $analytics = $analyticsService->getLastReport(CompositeReport::feedReportByShop(), $shop->id);
        $shops = Shop::all();
        $currentShop = $shop;

        return view('admin.feeds.analytics', compact('currentShop', 'analytics', 'shops', 'shop'));
    }
}
