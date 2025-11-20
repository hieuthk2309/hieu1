<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
	return view('welcome');
});

Route::get('/hieu', function () {
	return 'Hello World';
});

Route::get('products', [ProductController::class, 'index']);