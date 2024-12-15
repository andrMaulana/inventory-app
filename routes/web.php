<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apps\DashboardController;

// home
Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'apps', 'as' => 'apps.', 'middleware' => ['auth']], function(){
    // dashboard
    Route::get('dashboard', DashboardController::class)->name('dashboard');
});
