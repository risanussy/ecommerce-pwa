<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SellController;

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

Route::get('/pay', function () {
    return view('pay');
});

Route::get('/tq', function () {
    return view('tq');
});

Route::resource('/products', ProductController::class);
Route::post('/sell', [SellController::class, 'store'])->name('sell.store');
Route::get('/admin/sell', [SellController::class, 'index'])->name('sell.index');
Route::resource('/sell', SellController::class);
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store') ;
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('/cart/{id}', [CartController::class, 'show'])->name('cart.show');