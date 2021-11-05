<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Shop;
use Illuminate\Http\Request;
use function view;

class OffersController extends Controller
{
    public function index(Request $request)
    {
        $query = Offer::with('shop');
        $query->when($request->shop, function ($query, $value) {
            $query->whereIn('shop_id', $value);
        });
        $offers = $query->paginate(16);

        $shops = Shop::active()->get();

        return view('admin.offers.index', compact('offers', 'shops'));
    }
}
