<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\System\EmailServiceController;
use App\Http\Controllers\System\EventInitController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Admin\EventPresenceController;
use App\Http\Controllers\System\DataInitController;
use App\Http\Controllers\System\CronController;

Route::get('/', function () {
    return '_apiperki_';
});
Route::get('/panel/print-abstract', [PostController::class, 'printPost']);
Route::get('/panel/preview-abstract', [PostController::class, 'previewAbstract']);
Route::get('/panel/register-user', [UserController::class, 'registerUser']);
Route::get('/scanner', [AuthController::class, 'scannerPanel']);
Route::get('/panel', [AuthController::class, 'adminPanel']);
Route::get('/panel/{path}', [AuthController::class, 'adminPanel'])->where('path', '([A-z\d\-\/_.]+)?');

Route::get('/auth/{path}', [AuthController::class, 'auth'])
    ->where('path', '([A-z\d\-\/_.]+)?');

// Report
Route::get('/event-member/{slug}', [EventController::class, 'event_member']);
Route::get('/event-presence/{slug}', [EventController::class, 'event_presence']);
Route::get('/transaction-recap', [TransactionController::class, 'transaction_recap']);
Route::get('/voucher-usage', [VoucherController::class, 'voucherRecap']);

Route::get('login', [AuthController::class, 'login_view']);
Route::post('login', [AuthController::class, 'login']);
Route::get('/send-qr-code/{transaction_id}', [EmailServiceController::class, 'qr_code_access']);
Route::get('send-qrcode-email/{transaction_id}', [EmailServiceController::class, 'qr_code_access']);

Route::get('event-init', [EventInitController::class, 'event_init']);
Route::get('sample-qrcode', [TestController::class, 'sample_qrcode']);
Route::get('print/event-presence/{event_user_id}', [EventPresenceController::class, 'print_event_presence']);
Route::get('print/transaction-presence/{transaction_id}', [EventPresenceController::class, 'print_transaction_presence']);

Route::get('print/invoice-pdf/{transaction_id}', [TransactionController::class, 'invoice_pdf']);

// TEST
Route::get('test', [EmailServiceController::class, 'send_event_certificate']);
Route::get('print-by-name', [TestController::class, 'print_by_name']);
Route::get('send_certy', [TestController::class, 'send_certy']);
Route::get('create_certy_mail_log', [TestController::class, 'create_certy_mail_log']);
Route::get('contacts', [TestController::class, 'contactList']);
Route::get('sync-contacts', [DataInitController::class, 'insertToContact']);
Route::get('generate-announcement', [CronController::class, 'create_announcement_mail_log']);
Route::get('send-announcement', [CronController::class, 'send_announcement_email']);
Route::get('upload-firebase', [\App\Http\Controllers\System\UploadFirebaseController::class, 'firebaseUpload']);
