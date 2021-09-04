<?php

namespace App\Http\Controllers\Admin\Feeds;

use App\Services\Feed\Analytics\CompositeReportFactory;
use App\Http\Controllers\Controller;
use App\Models\Analytics;
use App\Models\Shop;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(Shop $shop, CompositeReportFactory $factory)
    {
        $analytics = Analytics::where('shop_id', $shop->id)->latest()->first();

        if ($analytics) {
            $report = $factory->build();

            $report->setValues($analytics->data);
        } else {
            $report = null;
        }

        return view('admin.feeds.analytics', compact('shop', 'analytics', 'report'));
    }
}
