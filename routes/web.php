<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

function setAppLocaleFromSession(): void
{
    $locale = session('locale', 'en');
    if ($locale === 'id') {
        $locale = 'in';
    }
    app()->setLocale($locale);
}

Route::get('/', function () {
    setAppLocaleFromSession();
    return view('auth.login');
});

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if ($request->email !== 'arumaliyaan034@gmail.com' || $request->password !== 'aly4326') {
        return back()->withInput()->with('login_error', 'Email atau password salah.');
    }

    $request->session()->put('logged_in', true);
    return redirect('/index');
});

Route::get('/register', function () {
    setAppLocaleFromSession
          ();
    return view('auth.register');
});

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