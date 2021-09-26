<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Report\ReportService;
use App\Services\Report\CompositeReport;

class HomeController extends Controller
{
    public function index(ReportService $reportService){
        $report = $reportService->getLastReport(CompositeReport::catalogReportTotal());

        return view('admin.home.index', compact('report'));
    }
}
