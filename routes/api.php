<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Event\RegisterController as EventRegisterController;

use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\EvenTransactionController;
use App\Http\Controllers\User\EventController;
use App\Http\Controllers\User\AbstractController;

use App\Http\Controllers\System\DataInitController;
use App\Http\Controllers\System\UploadFileController;

// ADMIN API
Route::post('/', function (){
    return 'app';
});
Route::post('/adm/login', [AdminAuthController::class, 'login']);
Route::post('/set-data', [DataInitController::class, 'init']);

Route::group(['prefix' => 'adm', 'middleware' => 'auth:sanctum'], function () {
    Route::get('profile', [AdminAuthController::class, 'profile']);

    Route::get('dashboard-stat', [DashboardController::class, 'statistics']);
    Route::get('dashboard-chart', [DashboardController::class, 'chart']);
    Route::get('dashboard-user-stat', [DashboardController::class, 'user_stat']);
    Route::get('dashboard-event-purchase', [DashboardController::class, 'event_purchase']);
    Route::get('sidebar-label', [DashboardController::class, 'sidebar_label']);

    Route::resource('transactions', AdminTransactionController::class);
    Route::resource('posts', AdminPostController::class);
    Route::resource('users', AdminUserController::class);

    Route::post('transaction-confirm', [AdminTransactionController::class, 'confirm']);
    Route::patch('transaction-delete', [AdminTransactionController::class, 'delete_transaction']);

    Route::post('scan-event', [AdminEventController::class, 'scan_event']);
});
// =========

// AUTH API
Route::group(['prefix' => 'pub', 'middleware' => 'auth:sanctum'], function () {
    Route::post('logout', [UserAuthController::class, 'logout']);

    Route::get('profile', [UserAuthController::class, 'profile']);
    Route::get('packages-active', [UserAuthController::class, 'package_active']);
    Route::patch('profile', [UserAuthController::class, 'profile_update']);
    Route::patch('profile-photo', [UserAuthController::class, 'profile_photo_update']);
    Route::get('events-list', [EvenTransactionController::class, 'event_list']);
    Route::get('events-list-2', [EvenTransactionController::class, 'event_list_2']);
    Route::post('calculate-price', [EvenTransactionController::class, 'calculate_price']);
    Route::post('calculate-price-2', [EvenTransactionController::class, 'calculate_price_2']);
    Route::post('create-payment', [EvenTransactionController::class, 'create_payment']);
    Route::post('create-payment-2', [EvenTransactionController::class, 'create_payment_2']);
    Route::get('transaction/{transaction_number}', [EvenTransactionController::class, 'show']);
    Route::get('pending-transaction-count', [EvenTransactionController::class, 'pending_transaction_count']);

    Route::get('transaction-list', [EvenTransactionController::class, 'transaction_list']);
    Route::post('transaction-transfer-proof', [EvenTransactionController::class, 'transfer_proof']);
    Route::get('event-schedules', [EventController::class, 'event_schedule']);

    Route::get('abstracts', [AbstractController::class, 'abstract_list']);
    Route::post('abstracts', [AbstractController::class, 'abstract_submit']);
    Route::post('abstracts/{id}', [AbstractController::class, 'abstract_update']);
    Route::delete('abstracts/{id}', [AbstractController::class, 'abstract_delete']);
});
// =========

// PUBLIC DYNAMIC API
Route::group(['prefix' => 'pub', 'middleware' => 'public_dynamic'], function () {
    Route::get('check-token', [UserAuthController::class, 'check_token']);

    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('upload-file', [UploadFileController::class, 'store']);

    // register event
    Route::get('register-event', [EventRegisterController::class, 'register_event']);
    Route::post('guest', [HomeController::class, 'guest_log']);
});
// =========

// PUBLIC API
Route::group(['prefix' => 'pub'], function () {
    Route::post('login', [UserAuthController::class, 'login']);
    Route::post('logas', [UserAuthController::class, 'logas']);
    Route::post('login-by-google', [UserAuthController::class, 'login_by_google']);
    Route::post('verify-google', [HomeController::class, 'google']);
    Route::post('send-new-password', [UserAuthController::class, 'send_new_password']);
    Route::post('check-otp-reset-password', [UserAuthController::class, 'check_otp_reset_password']);

    Route::get('events', [HomeController::class, 'events']);
    Route::get('cta-event', [HomeController::class, 'cta_event']);
    Route::get('get-job-types', [HomeController::class, 'job_types']);
    Route::get('speakers', [HomeController::class, 'speakers']);
    Route::get('committee', [HomeController::class, 'committee']);
    Route::get('schedule', [HomeController::class, 'schedule']);
    Route::get('pricing', [HomeController::class, 'pricing']);
    Route::get('hero-banner', [HomeController::class, 'hero_banner']);
    Route::get('sponsor-slider', [HomeController::class, 'sponsor_slider']);
});
// =========
