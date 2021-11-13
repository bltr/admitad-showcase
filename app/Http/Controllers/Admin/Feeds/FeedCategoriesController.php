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
            ->defaultOrder()
            ->get()
            ->toTree();

        return view('admin.feeds.categories', compact('shop', 'categories'));
    }
}
