<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanelControl\DashboardController;
use App\Http\Controllers\PanelControl\MovieController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'id'])) {
        abort(400);
    }
    session(['locale' => $locale]);
    App::setLocale($locale);
    return redirect()->back();
})->name('lang.switch');

// Rute Auth
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register_process'])->name('signup');
Route::post('/login', [AuthController::class, 'login'])->name('signin');
Route::get('/logout', [AuthController::class, 'logout'])->name('signout');

// Rute Movie dan Favorite
Route::get('/movies', [MovieController::class, 'index'])->name('movies');
Route::get('/movies/{imdbID}', [MovieController::class, 'detail'])->name('movies.detail');
Route::post('/favorite/add', [MovieController::class, 'addFavorite'])->name('favorite.add');
Route::delete('/favorite/remove', [MovieController::class, 'removeFavorite'])->name('favorite.remove');

// Halaman Favorites (sesuai referensi, gunakan route 'favorites')
Route::get('/favorites', function () {
    return view('panel_control.my'); // pastikan file panel_control/my.blade.php ada
})->name('favorites');

// Rute Dashboard dengan middleware checkLogin (atau bisa gunakan middleware 'auth' jika sudah sesuai)
Route::prefix('panel_control')->middleware('checkLogin')->group(function () {
    Route::get('index', [DashboardController::class, 'index'])->name('dashboard');
});
