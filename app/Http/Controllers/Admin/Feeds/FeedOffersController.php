<?php

namespace App\Http\Controllers\Admin\Feeds;

use App\Http\Controllers\Controller;
use App\Models\FeedOffer;
use App\Models\Shop;

class FeedOffersController extends Controller
{
    public function index(Shop $shop)
    {
        $offers = $shop->feed_offers()
            ->with('feed_category')
            ->selectRaw('*, jsonb_pretty(data) as data')
            ->paginate(20);

        return view('admin.feeds.offers', compact('shop', 'offers'));
    }
}
