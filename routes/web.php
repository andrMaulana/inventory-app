<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Apps\RoleController;
use App\Http\Controllers\Apps\UserController;
use App\Http\Controllers\Apps\OrderController;
use App\Http\Controllers\Apps\StockController;
use App\Http\Controllers\Apps\ReportController;
use App\Http\Controllers\Apps\ProductController;
use App\Http\Controllers\Apps\CategoryController;
use App\Http\Controllers\Apps\SupplierController;
use App\Http\Controllers\Apps\DashboardController;
use App\Http\Controllers\Apps\PermissionController;
use App\Http\Controllers\Apps\TransactionController;
use App\Http\Controllers\Web\ProductController as WebProductController;
use App\Http\Controllers\Web\CategoryController as WebCategoryController;
use App\Http\Controllers\Web\TransactionController as WebTransactionController;

// home
Route::get('/', HomeController::class)->name('home');

// product
Route::controller(WebProductController::class)->as('product.')->group(function(){
    Route::get('/product', 'index')->name('index');
    Route::get('/product/{product:slug}', 'show')->name('show');
});

// category
Route::controller(WebCategoryController::class)->as('category.')->group(function(){
    Route::get('/category', 'index')->name('index');
    Route::get('/category/{category:slug}', 'show')->name('show');
});

// cart
Route::controller(CartController::class)->middleware('auth')->as('cart.')->group(function(){
    Route::get('/cart', 'index')->name('index');
    Route::post('/cart/{product:id}', 'store')->name('store');
    Route::put('/cart/update/{cart:id}', 'update')->name('update');
    Route::delete('/cart/delete/{cart}', 'destroy')->name('destroy');
});

// transaction
Route::post('/transaction', WebTransactionController::class)->middleware('auth')->name('transaction.store');

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
