<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\System\DataInitController;
use App\Http\Controllers\User\EvenTransactionController;

// ADMIN API
Route::post('/adm/login', [AdminAuthController::class, 'login']);
Route::post('/set-data', [DataInitController::class, 'init']);
Route::group(['prefix' => 'adm', 'middleware' => 'auth:sanctum'], function () {
    Route::get('profile', [AdminAuthController::class, 'profile']);
});
// =========

// PUBLIC AUTH API
Route::group(['prefix' => 'pub', 'middleware' => 'auth:sanctum'], function () {
    Route::get('profile', [UserAuthController::class, 'profile']);
    Route::get('events-list', [EvenTransactionController::class, 'event_list']);
    Route::post('calculate-price', [EvenTransactionController::class, 'calculate_price']);
    Route::post('create-payment', [EvenTransactionController::class, 'create_payment']);
    Route::get('transaction/{transaction_number}', [EvenTransactionController::class, 'show']);
});
// =========

// PUBLIC DYNAMIC API
Route::group(['prefix' => 'pub', 'middleware' => 'public_dynamic'], function () {
    Route::get('check-token', [UserAuthController::class, 'check_token']);

    Route::post('register', [UserAuthController::class, 'register']);
});
// =========

// PUBLIC API
Route::group(['prefix' => 'pub'], function () {
    Route::post('login', [UserAuthController::class, 'login']);
    Route::post('login-by-google', [UserAuthController::class, 'login_by_google']);
    Route::post('verify-google', [HomeController::class, 'google']);

    Route::get('get-job-types', [HomeController::class, 'job_types']);
    Route::get('speakers', [HomeController::class, 'speakers']);
});
// =========
