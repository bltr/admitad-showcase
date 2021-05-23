<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;

class ShopsController extends Controller
{
    public function index()
    {
        return view('admin.shops.index', ['shops' => Shop::all()]);
    }
}
