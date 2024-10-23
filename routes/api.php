<?php

use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/chat-bot', [ChatBotController::class, 'listenToReplies']);

// Route::middleware('auth:sanctum')->group(function () {
Route::get('/products/suggestions', [ProductController::class, 'suggestions'])->name('products.suggestions');
Route::get('/products/get/{product}', [ProductController::class, 'get'])->name('products.get');
Route::get('/suppliers/suggestions', [SupplierController::class, 'suggestions'])->name('suppliers.suggestions');
// });
