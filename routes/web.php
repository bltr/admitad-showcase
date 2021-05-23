<?php

use App\Http\Controllers\Admin\Feeds\AnalyticsController;
use App\Http\Controllers\Admin\Feeds\CategoriesController;
use App\Http\Controllers\Admin\Feeds\OffersController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ShopsController;
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

    Route::prefix('/shops')->name('shops.')->group(function() {
        Route::get('/', [ShopsController::class, 'index'])->name('index');
        Route::get('/{shop}/offers', [OffersController::class, 'index'])->name('feeds.offers');
        Route::get('/{shop}/categories', [CategoriesController::class, 'index'])->name('feeds.categories');
        Route::get('/{shop}/analytics', [AnalyticsController::class, 'index'])->name('feeds.analytics');
    });
});
