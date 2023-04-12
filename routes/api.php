<?php

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
// end ADMIN API

// PUBLIC AUTH API
Route::post('/pub/login', [UserAuthController::class, 'login']);
Route::post('/pub/login-by-google', [UserAuthController::class, 'login_by_google']);
Route::group(['prefix' => 'pub', 'middleware' => 'auth:sanctum'], function(){
    Route::get('profile', [UserAuthController::class, 'profile']);
});
// end of PUBLIC AUTH API

// PUBLIC API
Route::group(['prefix' => 'pub'], function(){
    Route::post('verify-google', [HomeController::class, 'google']);

    Route::get('speakers', [HomeController::class, 'speakers']);
    Route::get('events', [HomeController::class, 'events']);

});

// end PUBLIC API
