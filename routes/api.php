<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/products',[ProductsController::class, 'index']);
Route::post('/products',[ProductsController::class, 'store']);
Route::get('/products/{id}',[ProductsController::class, 'find_product']);