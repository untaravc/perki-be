<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\TransactionController;

Route::get('/', function (){
    return 'perki-src';
});
Route::get('/panel/print-abstract', [PostController::class, 'printPost']);
Route::get('/panel/preview-abstract', [PostController::class, 'previewAbstract']);
Route::get('/panel', [AuthController::class, 'adminPanel']);
Route::get('/panel/{path}', [AuthController::class, 'adminPanel'])->where( 'path' , '([A-z\d\-\/_.]+)?' );
Route::get('/scanner', [AuthController::class, 'scannerPanel']);

// Report
Route::get('/event-member/{slug}', [EventController::class, 'event_member']);
Route::get('/event-presence/{slug}', [EventController::class, 'event_presence']);
Route::get('/transaction-recap', [TransactionController::class, 'transaction_recap']);

Route::get('login', [AuthController::class, 'login_view']);
Route::post('login', [AuthController::class, 'login']);
Route::get('/send-qr-code/{transaction_id}', [\App\Http\Controllers\System\EmailServiceController::class, 'qr_code_access']);
Route::get('send-qrcode-email/{transaction_id}', [\App\Http\Controllers\System\EmailServiceController::class, 'qr_code_access']);

Route::get('event-init', [\App\Http\Controllers\System\EventInitController::class, 'event_init']);
Route::get('sample-qrcode', [\App\Http\Controllers\TestController::class, 'sample_qrcode']);
Route::get('print/event-presence/{event_user_id}', [\App\Http\Controllers\Admin\EventPresenceController::class, 'print_event_presence']);
Route::get('print/transaction-presence/{transaction_id}', [\App\Http\Controllers\Admin\EventPresenceController::class, 'print_transaction_presence']);

Route::get('print/invoice-pdf/{transaction_id}', [TransactionController::class, 'invoice_pdf']);

// TEST
Route::get('test', [\App\Http\Controllers\TestController::class, 'check_transaction_status']);
Route::get('print-by-name', [\App\Http\Controllers\TestController::class, 'print_by_name']);
Route::get('create_certy_mail_log', [\App\Http\Controllers\TestController::class, 'create_certy_mail_log']);
//Route::get('reset-presensi-1', [\App\Http\Controllers\TestController::class, 'reset_presensi_1']);
