<?php

namespace App\Http\Controllers\Admin\Feeds;

use App\Services\Feed\AnalyticsServiceByShop;
use App\Http\Controllers\Controller;
use App\Models\Shop;

class AnalyticsController extends Controller
{
    public function index(Shop $shop, AnalyticsServiceByShop $analyticsService)
    {
        $analytics = $analyticsService->getLastReport($shop->id);
        $shops = Shop::all();
        $currentShop = $shop;

        return view('admin.feeds.analytics', compact('currentShop', 'analytics', 'shops', 'shop'));
    }
}
