<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\Api\AuthenticationController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('/products',[ProductsController::class, 'index']);
Route::post('/products',[ProductsController::class, 'store']);
Route::get('/products/{id}',[ProductsController::class, 'find_product']);

//user

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    
    // Optional: Admin routes
    Route::get('/admin-only', function () {
        return response()->json(['message' => 'Admin route']);
    })->middleware('admin');
});