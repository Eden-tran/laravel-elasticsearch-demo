<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;

Route::get('/', function () {
    return view('welcome');
});

// Route::prefix('search')->group(function () {
//     Route::get('/index', [SearchController::class, 'index']);
//     Route::get('/search', [SearchController::class, 'search']);
// });
Route::prefix('product')->group(function () {
    Route::get('/search', [ProductController::class, 'search']);
});
