<?php

use App\Http\Controllers\Apps\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apps\DashboardController;
use App\Http\Controllers\Apps\OrderController;
use App\Http\Controllers\Apps\PermissionController;
use App\Http\Controllers\Apps\ProductController;
use App\Http\Controllers\Apps\ReportController;
use App\Http\Controllers\Apps\RoleController;
use App\Http\Controllers\Apps\StockController;
use App\Http\Controllers\Apps\SupplierController;
use App\Http\Controllers\Apps\TransactionController;
use App\Http\Controllers\Apps\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'apps', 'as' => 'apps.', 'middleware' => ['auth']], function(){
    // dashboard
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    // categories
    Route::resource('categories', CategoryController::class)->except(['show']);
    // suppliers
    Route::resource('suppliers', SupplierController::class)->except(['show']);
    // products
    Route::resource('products', ProductController::class)->except(['show']);
    // stocks
    Route::group(['as' => 'stocks.', 'prefix' => 'stocks'], function(){
        Route::get('/', [StockController::class, 'index'])->name('index');
        Route::post('/{product}', [StockController::class, 'store'])->name('store');
    });
    // transactions
    Route::get('/transactions', TransactionController::class)->name('transaction');
  	// orders
    Route::resource('orders', OrderController::class);
    // reports
    Route::controller(ReportController::class)->as('reports.')->prefix('reports')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/filter', 'filter')->name('filter');
        Route::get('/download/{type}/{from_date}/{to_date}', 'download')->name('download');
    });
    // permissions
    Route::resource('permissions', PermissionController::class)->except(['create', 'edit', 'show']);
    // roles
    Route::resource('roles', RoleController::class);
    // users
    Route::resource('users', UserController::class)->only(['index', 'update', 'destroy']);
});
