<?php

namespace App\Http\Controllers\Admin\Feeds;

use App\Services\Feed\AnalyticsService;
use App\Http\Controllers\Controller;
use App\Models\Shop;

class AnalyticsController extends Controller
{
    public function index(Shop $shop, AnalyticsService $analyticsService)
    {
        $view = $analyticsService->renderLastReport($shop);

        return view('admin.feeds.analytics', compact('shop', 'view'));
    }
}
