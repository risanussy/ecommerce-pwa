<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

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

Route::get('/admin', function () {
    return view('login');
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
Route::post('/buy', [TransactionController::class, 'buy'])->name('cart.buy');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::get('/cart', [TransactionController::class, 'index'])->name('cart.index');
Route::get('/admin/sell', [TransactionController::class, 'sell'])->name('cart.sell');
Route::post('/cart', [TransactionController::class, 'store'])->name('cart.store') ;
Route::get('/cart/{id}', [TransactionController::class, 'show'])->name('cart.show');
Route::delete('/cart/{id}', [TransactionController::class, 'destroy'])->name('cart.destroy');



Route::post('/sell/{id}/kirim', [TransactionController::class, 'kirim'])->name('sell.kirim');
Route::post('/sell/{id}/selesai', [TransactionController::class, 'selesai'])->name('sell.selesai');
Route::post('/sell/{id}/canceled', [TransactionController::class, 'canceled'])->name('sell.canceled');