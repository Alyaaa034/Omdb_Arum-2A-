<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

function setAppLocaleFromSession(): void
{
    $locale = session('locale', 'en');
    if ($locale === 'id') {
        $locale = 'in';
    }
    app()->setLocale($locale);
}
// Routing untuk Auth
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'register_process'])->name('signup');

Route::get('/index', function () {
    setAppLocaleFromSession();
    if (! session('logged_in', false)) {
        return redirect('/');
    }
    return view('panel_control.index');
});
Route::get('/My', function () {
    setAppLocaleFromSession();
    if (! session('logged_in', false)) {
        return redirect('/');
    }
    return view('panel_control.My');
});
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'in', 'id'])) {
        if ($locale === 'id') {
            $locale = 'in';
        }
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch'
);
Route::get('/logout', function () {
    session()->flush();
    return redirect('/');
});