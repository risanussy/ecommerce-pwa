<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\TransactionController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/chats/{id}', [ChatController::class, 'show']);
Route::post('/chats', [ChatController::class, 'store']);

Route::post('/buy-all/{id}', [TransactionController::class, 'buyAll']);
Route::post('/delete-all/{id}', [TransactionController::class, 'deleteAll']);
