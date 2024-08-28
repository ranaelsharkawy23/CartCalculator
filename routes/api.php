<?php
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\RateController;
use App\Http\Controllers\Api\DiscountController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/products', [ProductController::class,'store']);
Route::get('/products', [ProductController::class,'store']);


Route::post('/carts', [CartController::class,'store']);
Route::get('/carts/{id}', [CartController::class,'getCartDetails']);

Route::post('/rates', [RateController::class,'store']);
//Route::get('/carts/{id}', [CartController::class,'getCartDetails']);

Route::post('/discounts', [DiscountController::class,'store']);
Route::delete('/discounts/{id}', [DiscountController::class,'destroy']);