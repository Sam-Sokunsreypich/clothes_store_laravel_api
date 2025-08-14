<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return response()->json(['message' => 'Unauthenticated. Please log in.'], 401);
})->name('login');
// Route::post('/product',[ProductController::class, 'CreateProduct']);

