<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ChatController;

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

// Authenticate

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// website

Route::get('/', function () {
    return view('home');
});

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/resi', function () {
    return view('resi');
});

Route::get('/pay', function () {
    return view('pay');
});

Route::get('/tq', function () {
    return view('tq');
});

// Admin

Route::get('/admin', function () {
    return view('login');
});

Route::get('/admin/sell', function () {
    return view('sell');
});

Route::get('/admin/product', function () {
    return view('product');
});

Route::get('/admin/list', function () {
    return view('list');
});

Route::get('/admin/chat', function () {
    return view('chat');
});

// Routes

Route::resource('/products', ProductController::class);
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');

Route::post('/buy', [TransactionController::class, 'buy'])->name('cart.buy');
Route::get('/cart', [TransactionController::class, 'index'])->name('cart.index');
Route::get('/resi', [TransactionController::class, 'resi'])->name('cart.resi');
Route::get('/admin/sell', [TransactionController::class, 'sell'])->name('cart.sell');
Route::post('/cart', [TransactionController::class, 'store'])->name('cart.store') ;
Route::get('/cart/{id}', [TransactionController::class, 'show'])->name('cart.show');
Route::delete('/cart/{id}', [TransactionController::class, 'destroy'])->name('cart.destroy');

Route::post('/sell/{id}/kirim', [TransactionController::class, 'kirim'])->name('sell.kirim');
Route::post('/sell/{id}/selesai', [TransactionController::class, 'selesai'])->name('sell.selesai');
Route::post('/sell/{id}/canceled', [TransactionController::class, 'canceled'])->name('sell.canceled');

Route::get('/admin/list', [AuthController::class, 'showUserName'])->name('user.name');

// Route::resource('/products', ProductController::class);
Route::post('/chat', [ChatController::class, 'store'])->name('chat.store') ;
Route::get('/admin/chat', [ChatController::class, 'index'])->name('chat.index');
