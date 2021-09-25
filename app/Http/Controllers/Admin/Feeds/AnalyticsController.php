<?php

namespace App\Http\Controllers\Admin\Feeds;

use App\Services\Feed\AnalyticsServiceByShop;
use App\Http\Controllers\Controller;
use App\Models\Shop;

class AnalyticsController extends Controller
{
    public function index(Shop $shop, AnalyticsServiceByShop $analyticsService)
    {
        $view = $analyticsService->renderLastReport($shop);
        $shops = Shop::all();
        $currentShop = $shop;

        return view('admin.feeds.analytics', compact('currentShop', 'view', 'shops', 'shop'));
    }
}
