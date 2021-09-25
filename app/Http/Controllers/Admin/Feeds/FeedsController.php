<?php

namespace App\Http\Controllers\Admin\Feeds;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class FeedsController extends Controller
{
    public function index()
    {
        $shops = Shop::all();

        return view('admin.feeds.index', compact('shops'));
    }

    public function toggleActivity(Shop $shop)
    {
        $shop->is_active = !$shop->is_active;
        $shop->save();

        return back();
    }

    public function importType(Shop $shop, Request $request)
    {
        $shop->import_type = $request->import_type;
        $shop->save();

        return back();
    }
}
