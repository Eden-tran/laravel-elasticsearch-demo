<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('search')->group(function () {
    Route::get('/index', [SearchController::class, 'index']);
    Route::get('/search', [SearchController::class, 'search']);
});

