<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

use App\Http\Controllers\User\AuthController as UserAuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function (){
   return 'API Ready';
});

/**
 * ADMIN API
 */
Route::post('/adm/login', [AdminAuthController::class, 'login']);

Route::group(['prefix' => 'adm', 'middleware' => 'auth:sanctum'], function(){
    Route::get('profile', [AdminAuthController::class, 'profile']);
});

/**
 * Public API
 */

Route::post('/pub/login', [UserAuthController::class, 'login']);
Route::group(['prefix' => 'pub', 'middleware' => 'auth:sanctum'], function(){
    Route::get('profile', [UserAuthController::class, 'profile']);
});


