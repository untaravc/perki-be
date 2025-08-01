<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventPresenceController;
use App\Http\Controllers\Admin\MailLogController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\VoucherController;

use App\Http\Controllers\Event\BannerController;
use App\Http\Controllers\Event\CommitteeController;
use App\Http\Controllers\Event\GuidanceController;
use App\Http\Controllers\Event\PricingController;
use App\Http\Controllers\Event\RegisterController as EventRegisterController;
use App\Http\Controllers\Event\ScheduleController;
use App\Http\Controllers\Event\SpeakerController;
use App\Http\Controllers\Event\SponsorController;

use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\User\EvenTransactionController;
use App\Http\Controllers\User\EventController;
use App\Http\Controllers\User\AbstractController;
use App\Http\Controllers\User\EventTransaction24Controller;
use App\Http\Controllers\User\EventTransactionCarvepController;
use App\Http\Controllers\User\EventTransactionJfu25Controller;
use App\Http\Controllers\User\EventTransactionJcu25Controller;
use App\Http\Controllers\User\GroupController;

use App\Http\Controllers\System\DataInitController;
use App\Http\Controllers\System\UploadFileController;
use App\Http\Controllers\System\CronController;

// ADMIN API
Route::post('/', function () {
    return 'app';
});
Route::post('/adm/login', [AdminAuthController::class, 'login']);
Route::post('/set-data', [DataInitController::class, 'init']);
Route::post('/import-contact', [DataInitController::class, 'importContact']);
Route::get('/test', [CronController::class, 'sendRegisterProcess']);
Route::get('abstracts-send-accepted', [AbstractController::class, 'accepted_notification']);
Route::get('firebase-config', [UserAuthController::class, 'firebaseConfig']);

Route::group(['prefix' => 'adm', 'middleware' => 'auth:sanctum'], function () {
    Route::get('auth', [AdminAuthController::class, 'authJson']);
    Route::get('menu', [AdminAuthController::class, 'menu']);
    Route::get('profile', [AdminAuthController::class, 'profile']);

    Route::get('dashboard-stat', [DashboardController::class, 'statistics']);
    Route::get('dashboard-chart', [DashboardController::class, 'chart']);
    Route::get('dashboard-user-stat', [DashboardController::class, 'user_stat']);
    Route::get('dashboard-event-purchase', [DashboardController::class, 'event_purchase']);
    Route::get('sidebar-label', [DashboardController::class, 'sidebar_label']);
    Route::get('reviewer-list', [AdminPostController::class, 'reviewer_list']);
    Route::get('posts-stat', [AdminPostController::class, 'stats']);
    Route::get('menus-list', [MenuController::class, 'list']);
    Route::get('roles-list', [RoleController::class, 'list']);
    Route::get('menu-role', [MenuController::class, 'menuRole']);

    Route::resource('vouchers', VoucherController::class);
    Route::resource('transactions', AdminTransactionController::class);
    Route::resource('posts', AdminPostController::class);
    Route::resource('users', AdminUserController::class);
    Route::resource('event-presence', EventPresenceController::class);
    Route::resource('events', EventController::class);
    Route::resource('mail-logs', MailLogController::class);
    Route::resource('menus', MenuController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('sections', SectionController::class);

    Route::patch('transaction-delete', [AdminTransactionController::class, 'delete_transaction']);
    Route::get('transaction-notify/{transaction_id}', [AdminTransactionController::class, 'notify']);
    Route::patch('menu-role', [MenuController::class, 'menuRoleUpdate']);

    Route::patch('transaction-confirm', [AdminTransactionController::class, 'confirm']);
    Route::patch('transactions-validate/{transaction_id}', [AdminTransactionController::class, 'validate_transaction']);
    Route::post('scan-event', [AdminEventController::class, 'scan_event']);
    Route::post('post-set-reviewer/{post_id}', [AdminPostController::class, 'set_reviewer']);
    Route::post('post-review/{post_id}', [AdminPostController::class, 'post_review']);
});
// =========

// AUTH API
Route::group(['prefix' => 'pub', 'middleware' => 'auth:sanctum'], function () {
    Route::post('logout', [UserAuthController::class, 'logout']);

    Route::get('profile', [UserAuthController::class, 'profile']);
    Route::get('packages-active', [UserAuthController::class, 'package_active']);
    Route::patch('profile', [UserAuthController::class, 'profile_update']);
    Route::patch('profile-photo', [UserAuthController::class, 'profile_photo_update']);
    Route::get('transaction/{transaction_number}', [EvenTransactionController::class, 'show']);
    Route::get('pending-transaction-count', [EvenTransactionController::class, 'pending_transaction_count']);

    Route::get('transaction-list', [EvenTransactionController::class, 'transaction_list']);
    Route::post('transaction-transfer-proof', [EvenTransactionController::class, 'transfer_proof']);
    Route::get('event-schedules', [EventController::class, 'event_schedule']);
    Route::patch('update-transaction-name', [EvenTransactionController::class, 'update_transaction_name']);

    Route::get('abstracts', [AbstractController::class, 'abstract_list']);
    Route::get('abstracts-submit', [AbstractController::class, 'abstract_submit_open']);
    Route::post('abstracts', [AbstractController::class, 'abstract_submit']);
    Route::post('abstracts/{id}', [AbstractController::class, 'abstract_update']);
    Route::post('abstracts-poster/{id}', [AbstractController::class, 'abstract_poster']);
    Route::delete('abstracts/{id}', [AbstractController::class, 'abstract_delete']);

    Route::resource('groups', GroupController::class);
    Route::get('groups-ekg', [GroupController::class, 'mine']);

    // JUC 2023
    Route::get('events-list', [EvenTransactionController::class, 'event_list']);
    Route::get('events-list-2', [EvenTransactionController::class, 'event_list_2']);
    Route::post('calculate-price', [EvenTransactionController::class, 'calculate_price']);
    Route::post('calculate-price-2', [EvenTransactionController::class, 'calculate_price_2']);
    Route::post('create-payment', [EvenTransactionController::class, 'create_payment']);
    Route::post('create-payment-2', [EvenTransactionController::class, 'create_payment_2']);

    // JCU 2024
    Route::get('events-list-24', [EventTransaction24Controller::class, 'event_list']);
    Route::post('calculate-price-24', [EventTransaction24Controller::class, 'calculate_price']);
    Route::post('create-payment-24', [EventTransaction24Controller::class, 'create_payment']);

    // CVEP
    Route::get('events-list-carvep', [EventTransactionCarvepController::class, 'event_list']);
    Route::post('calculate-price-carvep', [EventTransactionCarvepController::class, 'calculate_price']);
    Route::post('create-payment-carvep', [EventTransactionCarvepController::class, 'create_payment']);

    // JFU 25
    Route::get('events-list-jfu25', [EventTransactionJfu25Controller::class, 'event_list']);
    Route::post('calculate-price-jfu25', [EventTransactionJfu25Controller::class, 'calculate_price']);
    Route::post('create-payment-jfu25', [EventTransactionJfu25Controller::class, 'create_payment']);

    // JCU 25
    Route::get('events-list-jcu25', [EventTransactionJcu25Controller::class, 'event_list']);
    Route::post('calculate-price-jcu25', [EventTransactionJcu25Controller::class, 'calculate_price']);
    Route::post('create-payment-jcu25', [EventTransactionJcu25Controller::class, 'create_payment']);
});
// =========

// PUBLIC DYNAMIC API
Route::group(['prefix' => 'pub', 'middleware' => 'public_dynamic'], function () {
    Route::get('check-token', [UserAuthController::class, 'check_token']);

    Route::get('registration', [UserAuthController::class, 'registerStatus']);
    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('upload-file', [UploadFileController::class, 'store']);
    Route::get('available-register', [EventRegisterController::class, 'availableRegister']);

    // register event
    Route::get('register-event', [EventRegisterController::class, 'register_event']);
    Route::post('guest', [HomeController::class, 'guest_log']);
    Route::get('video-on-demand', [HomeController::class, 'video_on_demand']);
});
// =========

// PUBLIC API
Route::group(['prefix' => 'pub'], function () {
    Route::get('open-register', [UserAuthController::class, 'open_register']);
    Route::post('login', [UserAuthController::class, 'login']);
    Route::post('logas', [UserAuthController::class, 'logas']);
    Route::post('login-by-google', [UserAuthController::class, 'login_by_google']);
    Route::post('verify-google', [HomeController::class, 'google']);
    Route::post('send-new-password', [UserAuthController::class, 'send_new_password']);
    Route::post('check-otp-reset-password', [UserAuthController::class, 'check_otp_reset_password']);

    Route::get('events', [HomeController::class, 'events']);
    Route::get('guidance', [GuidanceController::class, 'guidance']);
    Route::get('guidance-plataran', [GuidanceController::class, 'plataran']);
    Route::get('cta-event', [HomeController::class, 'cta_event']);
    Route::get('get-job-types', [HomeController::class, 'job_types']);
    Route::get('speakers', [SpeakerController::class, 'speakers']);
    Route::get('committee', [CommitteeController::class, 'committee']);
    Route::get('schedule', [ScheduleController::class, 'schedule']);
    Route::get('pricing', [PricingController::class, 'pricing']);
    Route::get('hero-banner', [BannerController::class, 'banner']);
    Route::get('sponsor-slider', [SponsorController::class, 'sponsor_slider']);
    Route::get('posters', [HomeController::class, 'posters']);
    Route::get('posters/{id}', [HomeController::class, 'posterShow']);

    // Presensi Event
    Route::get('scan-events', [EventController::class, 'index']);
    Route::get('scan-qrcode-event', [EventPresenceController::class, 'check_qrcode_data']);
    Route::post('scan-qrcode-event', [EventPresenceController::class, 'record_qrcode_data']);
});
// =========








































