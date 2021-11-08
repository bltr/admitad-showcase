<?php

namespace App\Http\Controllers\Admin\Feeds;

use App\Http\Controllers\Controller;
use App\Models\Shop;

class IndexController extends Controller
{
    public function index()
    {
        $shops = Shop::with('feed_offers_count', 'feed_offers_groups_count')
            ->get()
            ->sortByDesc('group_count');

        return view('admin.feeds.index', compact('shops'));
    }

    public function toggleActivity(Shop $shop)
    {
        $shop->toggleActivity();

        return back();
    }
}
