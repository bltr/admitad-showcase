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
}
