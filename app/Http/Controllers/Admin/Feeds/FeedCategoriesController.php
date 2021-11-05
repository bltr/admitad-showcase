<?php

namespace App\Http\Controllers\Admin\Feeds;

use App\Http\Controllers\Controller;
use App\Models\FeedCategory;
use App\Models\Shop;
use Illuminate\Http\Request;

class FeedCategoriesController extends Controller
{
    public function index(Shop $shop)
    {
        $categories = FeedCategory::where('shop_id', $shop->id)
            ->get()
            ->toTree();
        $shops = Shop::with('report')
            ->get()
            ->sortByDesc('group_count');
        $currentShop = $shop;

        return view('admin.feeds.categories', compact('currentShop', 'categories', 'shops'));
    }
}
