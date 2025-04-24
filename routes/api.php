<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Admin\ProductController;
use App\Http\Controllers\API\Admin\CategoryController;
use App\Http\Controllers\API\CartController;
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

// Public Routes
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// Authenticated Routes
Route::middleware('auth:sanctum')->group(function () {

    // User Profile
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Cart Routes
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/', [CartController::class, 'store']);
        Route::put('{id}', [CartController::class, 'update']);
        Route::delete('{id}', [CartController::class, 'destroy']);
        Route::delete('/', [CartController::class, 'clear']);
    });

    // Logout
    Route::post('/logout', [LoginController::class, 'logout']);
});

// Admin Routes (Protected by Role Middleware)
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('categories', CategoryController::class);
});
Route::post('/apply-coupon', [CouponController::class, 'apply']);


// Public product routes
Route::prefix('products')->group(function () {
    Route::get('/', [\App\Http\Controllers\API\ProductController::class, 'index']);                 // All products
    Route::get('/featured', [\App\Http\Controllers\API\ProductController::class, 'featured']);      // Featured products
    Route::get('/search', [\App\Http\Controllers\API\ProductController::class, 'search']);          // Search
    Route::get('/category/{id}', [\App\Http\Controllers\API\ProductController::class, 'byCategory']); // By category
    Route::get('/{id}', [\App\Http\Controllers\API\ProductController::class, 'show']);              // Product details
});
