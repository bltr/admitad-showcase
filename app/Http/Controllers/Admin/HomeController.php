<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Catalog\AnalyticsService;

class HomeController extends Controller
{
    public function index(AnalyticsService $analyticsService){
        $view = $analyticsService->renderLastReport();

        return view('admin.home.index', compact('view'));
    }
}
