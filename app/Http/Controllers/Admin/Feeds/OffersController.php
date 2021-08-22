<?php

namespace App\Http\Controllers\Admin\Feeds;

use App\Http\Controllers\Controller;
use App\Models\FeedOffer;
use App\Models\Shop;
use Illuminate\Http\Request;

class OffersController extends Controller
{
    public function index(Shop $shop)
    {
        $offers = FeedOffer::where('shop_id', $shop->id)
            ->selectRaw('*, jsonb_pretty(data) as data')
            ->orderBy('id')
            ->paginate(20);

        return view('admin.shops.feeds.offers', compact('shop', 'offers'));
    }
}
