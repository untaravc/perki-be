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
Route::get('/transaction-recap', [TransactionController::class, 'transaction_recap']);

Route::get('login', [AuthController::class, 'login_view']);
Route::post('login', [AuthController::class, 'login']);
Route::get('/send-qr-code/{transaction_id}', [\App\Http\Controllers\System\EmailServiceController::class, 'qr_code_access']);
Route::get('send-qrcode-email/{transaction_id}', [\App\Http\Controllers\System\EmailServiceController::class, 'qr_code_access']);

Route::get('event-init', [\App\Http\Controllers\System\EventInitController::class, 'event_init']);
Route::get('sample-qrcode', [\App\Http\Controllers\TestController::class, 'sample_qrcode']);
Route::get('print/event-presence/{event_user_id}', [\App\Http\Controllers\Admin\EventPresenceController::class, 'print_event_presence']);


Route::get('print/invoice-pdf/{transaction_id}', [TransactionController::class, 'invoice_pdf']);

// TEST
Route::get('test', [\App\Http\Controllers\System\EmailServiceController::class, 'send_certificate']);
Route::get('create_qr_mail_log', [\App\Http\Controllers\System\CronController::class, 'create_qr_mail_log']);
