<?php

use App\Http\Controllers\Admin\OffersController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\Feeds\ImportSettingsController;
use App\Http\Controllers\Admin\Feeds\FeedCategoriesController;
use App\Http\Controllers\Admin\Feeds\IndexController;
use App\Http\Controllers\Admin\Feeds\FeedOffersController;
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
        Route::get('/{shop}/offers', [FeedOffersController::class, 'index'])->name('offers');
        Route::get('/{shop}/categories', [FeedCategoriesController::class, 'index'])->name('categories');
        Route::get('/{shop}/import-grouping', [ImportSettingsController::class, 'grouping'])->name('import-grouping');
        Route::patch('/{shop}/import-grouping', [ImportSettingsController::class, 'setGrouping'])->name('set-import-grouping');
        Route::get('/{shop}/import-mapping', [ImportSettingsController::class, 'mapping'])->name('import-mapping');
        Route::patch('/{shop}/import-mapping', [ImportSettingsController::class, 'setMapping'])->name('set-import-mapping');
    });


    Route::get('/offers', [OffersController::class, 'index'])->name('offers.index');

    Route::resource('categories', CategoriesController::class);
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::patch('{category}/append-to', [CategoriesController::class, 'appendTo'])->name('append-to');
        Route::patch('{category}/up', [CategoriesController::class, 'up'])->name('up');
        Route::patch('{category}/down', [CategoriesController::class, 'down'])->name('down');
        Route::patch('{category}/first', [CategoriesController::class, 'first'])->name('first');
        Route::patch('{category}/last', [CategoriesController::class, 'last'])->name('last');
    });
});
