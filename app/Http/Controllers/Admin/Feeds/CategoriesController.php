<?php

namespace App\Http\Controllers\Admin\Feeds;

use App\Http\Controllers\Controller;
use App\Models\FeedCategory;
use App\Models\Shop;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(Shop $shop)
    {
        $categories = FeedCategory::where('shop_id', $shop->id)
            ->get()
            ->toTree();
        $shops = Shop::all();
        $currentShop = $shop;

        return view('admin.feeds.categories', compact('currentShop', 'categories', 'shops'));
    }
}
