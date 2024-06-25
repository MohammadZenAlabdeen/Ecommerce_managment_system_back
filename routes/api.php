<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
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
Route::post('/sellersDashboard/login',[AuthController::class,'apiLogin']);
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/products', [ProductController::class,'productsApi'])->name('products.list');
        Route::get('/products/{page}', [ProductController::class,'productsApi'])->name('products.list');
Route::post('/products/search/{page}', [ProductController::class,'searchApi'])->name('products.search');   
    });
