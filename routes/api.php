<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\NotifController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/midtrans', [MidtransController::class, 'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/chats/{id}', [ChatController::class, 'show']);
Route::post('/chats', [ChatController::class, 'store']);

Route::get('/notif', [NotifController::class, 'index']);
Route::get('/notif/{id}', [NotifController::class, 'show']);
Route::post('/notif', [NotifController::class, 'store']);

Route::post('/buy-all/{id}', [TransactionController::class, 'buyAll']);
Route::post('/delete-all/{id}', [TransactionController::class, 'deleteAll']);
