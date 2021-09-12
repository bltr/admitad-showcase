<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Catalog\AnalyticsService;

class HomeController extends Controller
{
    public function index(AnalyticsService $service){
        $view = $service->renderLastReport();

        return view('admin.home.index', compact('view'));
    }
}
