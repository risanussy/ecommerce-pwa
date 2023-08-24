<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Tampilan login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Tampilan pendaftaran
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

// Aksi pendaftaran
Route::post('/register', [AuthController::class, 'register']);

// Aksi login
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('home');
});

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/admin/sell', function () {
    return view('sell');
});

Route::get('/admin/product', function () {
    return view('product');
});

Route::resource('/products', ProductController::class);