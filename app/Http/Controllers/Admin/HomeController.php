<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Analytics\AnalyticsService;
use App\Services\Analytics\CompositeReport;

class HomeController extends Controller
{
    public function index(AnalyticsService $analyticsService){
        $analytics = $analyticsService->getLastReport(CompositeReport::catalogReportTotal());

        return view('admin.home.index', compact('analytics'));
    }
}
