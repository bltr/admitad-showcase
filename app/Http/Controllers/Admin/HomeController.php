<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PrecomputedValues\PrecomputedValuesService;

class HomeController extends Controller
{
    public function index(PrecomputedValuesService $computingService){
        $values = $computingService->getLastTotalValues();

        return view('admin.home.index', compact('values'));
    }
}
