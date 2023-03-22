<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\System\DataInitController;

// ADMIN API
Route::post('/adm/login', [AdminAuthController::class, 'login']);
Route::post('/set-data', [DataInitController::class, 'init']);
Route::group(['prefix' => 'adm', 'middleware' => 'auth:sanctum'], function(){
    Route::get('profile', [AdminAuthController::class, 'profile']);
});

// PUBLIC AUTH API
Route::post('/pub/login', [UserAuthController::class, 'login']);
Route::group(['prefix' => 'pub', 'middleware' => 'auth:sanctum'], function(){
    Route::get('profile', [UserAuthController::class, 'profile']);
});

// PUBLIC API
Route::group(['prefix' => 'pub'], function(){
    Route::get('speakers', [HomeController::class, 'speakers']);
    Route::get('events', [HomeController::class, 'events']);
});
