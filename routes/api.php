<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/check', [AuthController::class, 'check']);

    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites', [FavoriteController::class, 'storeAndRemove']);

    Route::get('/baskets', [BasketController::class, 'index']);
    Route::post('/baskets', [BasketController::class, 'storeAndRemove']);

    Route::post('/order', [OrderController::class, 'store']);
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/category/{category}', [CategoryController::class, 'show']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{product}', [ProductController::class, 'show']);

Route::get('/week-products', [ProductController::class, 'indexWeekProducts']);

Route::get('/popular-products', [ProductController::class, 'indexPopularProducts']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
