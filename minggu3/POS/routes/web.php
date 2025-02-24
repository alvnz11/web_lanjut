<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/food-beverage', [CategoryController::class, 'food']);
    Route::get('/beauty-health', [CategoryController::class, 'beauty']);
    Route::get('/home-care', [CategoryController::class, 'home']);
    Route::get('/baby-kid', [CategoryController::class, 'baby']);
});

Route::get('/user/{id}/name/{name}', function ($id, $name) {
    return view('user', compact('id', 'name'));
});


