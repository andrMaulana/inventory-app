<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apps\RoleController;
use App\Http\Controllers\Apps\UserController;
use App\Http\Controllers\Apps\StockController;
use App\Http\Controllers\Apps\ProductController;
use App\Http\Controllers\Apps\CategoryController;
use App\Http\Controllers\Apps\SupplierController;
use App\Http\Controllers\Apps\DashboardController;
use App\Http\Controllers\Apps\PermissionController;
use App\Http\Controllers\Apps\TransactionController;

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
    Route::controller(StockController::class)->as('stocks.')->prefix('stocks')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::post('/{product}', 'store')->name('store');
    });
    // transactions
    Route::get('/transactions', TransactionController::class)->name('transaction');
    // permissions
    Route::resource('permissions', PermissionController::class)->except(['create', 'edit', 'show']);
    // roles
    Route::resource('roles', RoleController::class);
    // users
    Route::resource('users', UserController::class)->only(['index', 'update', 'destroy']);
});
