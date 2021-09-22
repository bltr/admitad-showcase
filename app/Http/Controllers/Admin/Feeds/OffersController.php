<?php

namespace App\Http\Controllers\Admin\Feeds;

use App\Http\Controllers\Controller;
use App\Models\FeedOffer;
use App\Models\Shop;

class OffersController extends Controller
{
    public function index(Shop $shop)
    {
        $offers = FeedOffer::with('feed_category')
            ->where('shop_id', $shop->id)
            ->selectRaw('*, jsonb_pretty(data) as data')
            ->orderBy('id')
            ->paginate(20);
        $shops = Shop::all();

        return view('admin.feeds.offers', compact('shop', 'offers', 'shops'));
    }
}
