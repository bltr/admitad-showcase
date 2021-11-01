<?php

use App\Http\Controllers\Admin\Catalog\CatalogController;
use App\Http\Controllers\Admin\Catalog\CategoriesController as CatalogCategoriesController;
use App\Http\Controllers\Admin\Feeds\ReportController;
use App\Http\Controllers\Admin\Feeds\CategoriesController;
use App\Http\Controllers\Admin\Feeds\IndexController;
use App\Http\Controllers\Admin\Feeds\OffersController;
use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/admin')->name('admin.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::prefix('feeds')->name('feeds.')->group(function () {
        Route::get('/', [IndexController::class, 'index'])->name('index');
        Route::patch('/{shop}/toggle-activity', [IndexController::class, 'toggleActivity'])->name('toggle-activity');
        Route::patch('/{shop}/import-type', [IndexController::class, 'importType'])->name('import-type');
        Route::get('/{shop}/offers', [OffersController::class, 'index'])->name('offers');
        Route::get('/{shop}/categories', [CategoriesController::class, 'index'])->name('categories');
        Route::get('/{shop}/report', [ReportController::class, 'index'])->name('report');
        Route::get('/{shop}/report/{report}/group-deviation', [ReportController::class, 'groupDeviation'])->name('report.group-deviation');
    });

    Route::prefix('catalog')->name('catalog.')->group(function () {
        Route::get('/', [CatalogController::class, 'index'])->name('index');

        Route::resource('categories', CatalogCategoriesController::class);
        Route::patch('/categories/{category}/append-to', [CatalogCategoriesController::class, 'appendTo'])->name('categories.append-to');
        Route::patch('/categories/{category}/up', [CatalogCategoriesController::class, 'up'])->name('categories.up');
        Route::patch('/categories/{category}/down', [CatalogCategoriesController::class, 'down'])->name('categories.down');
        Route::patch('/categories/{category}/first', [CatalogCategoriesController::class, 'first'])->name('categories.first');
        Route::patch('/categories/{category}/last', [CatalogCategoriesController::class, 'last'])->name('categories.last');
    });
});
