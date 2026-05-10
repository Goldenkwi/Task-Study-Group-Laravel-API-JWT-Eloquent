<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Auth - public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Auth - protected
Route::middleware('auth:api')->group(function () {
    Route::post('/logout',  [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user', fn() => response()->json([
        'status' => 'success',
        'user'   => auth()->user()
    ]));
});

// Categories - index & show public, sisanya protected
Route::get('categories',        [CategoryController::class, 'index']);
Route::get('categories/{id}',   [CategoryController::class, 'show']);
Route::middleware('auth:api')->group(function () {
    Route::post('categories',           [CategoryController::class, 'store']);
    Route::put('categories/{id}',       [CategoryController::class, 'update']);
    Route::delete('categories/{id}',    [CategoryController::class, 'destroy']);
});

// Products - index & show public, sisanya protected
Route::get('products',          [ProductController::class, 'index']);
Route::get('products/{id}',     [ProductController::class, 'show']);
Route::middleware('auth:api')->group(function () {
    Route::post('products',             [ProductController::class, 'store']);
    Route::put('products/{id}',         [ProductController::class, 'update']);
    Route::delete('products/{id}',      [ProductController::class, 'destroy']);
});