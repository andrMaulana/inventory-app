<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apps\DashboardController;
use App\Http\Controllers\Apps\PermissionController;
use App\Http\Controllers\Apps\RoleController;
use App\Http\Controllers\Apps\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'apps', 'as' => 'apps.', 'middleware' => ['auth']], function(){
    // dashboard
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    // permissions
    Route::resource('permissions', PermissionController::class)->except(['create', 'edit', 'show']);
    // roles
    Route::resource('roles', RoleController::class);
    // users
    Route::resource('users', UserController::class)->only(['index', 'update', 'destroy']);
});
