<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanelControl\DashboardController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;


//swith language
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
        App::setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch');


//ROUTE

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register_process'])->name('signup');
Route::post('/login', [AuthController::class, 'login'])->name('signin');
Route::post('/logout', [AuthController::class, 'logout'])->name('signout');


Route::get('/Favorites', function () {
    return view('panel_control.My');
})->name('favorite');

Route::prefix('panel_control')->middleware('checkLogin')->group(function () {
    Route::get('index', [DashboardController::class, 'index'])->name('dashboard');
});

