<?php

namespace App\Http\Controllers\Admin\Feeds;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Services\Feed\AnalyticServiceTotal;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(AnalyticServiceTotal $analyticServiceTotal)
    {
        $shops = Shop::with('analytics')->get();
        $analyticsView = $analyticServiceTotal->renderLastReport();

        return view('admin.feeds.index', compact('shops', 'analyticsView'));
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
