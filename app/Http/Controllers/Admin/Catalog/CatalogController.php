<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Shop;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Offer::with('shop');
        $query->when($request->shop, function ($query, $value) {
            $query->whereIn('shop_id', $value);
        });
        $offers = $query->paginate(16);

        $shops = Shop::approved()->get();

        return view('admin.catalog.index', compact('offers', 'shops'));
    }
}
