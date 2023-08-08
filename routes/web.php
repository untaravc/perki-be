<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\System\EmailServiceController;

Route::get('/', function (){
    return 'perki-src';
});
Route::get('/panel/print-abstract', [PostController::class, 'printPost']);
Route::get('/panel/preview-abstract', [PostController::class, 'previewAbstract']);
Route::get('/panel', [AuthController::class, 'adminPanel']);
Route::get('/panel/{path}', [AuthController::class, 'adminPanel'])->where( 'path' , '([A-z\d\-\/_.]+)?' );
Route::get('/scanner', [AuthController::class, 'scannerPanel']);

Route::get('login', [AuthController::class, 'login_view']);
Route::post('login', [AuthController::class, 'login']);
Route::get('test-view', [\App\Http\Controllers\System\EmailServiceController::class, 'qr_code_access']);
Route::get('send-qrcode-email/{transaction_id}', [\App\Http\Controllers\System\EmailServiceController::class, 'qr_code_access']);

Route::get('event-init', [\App\Http\Controllers\System\EventInitController::class, 'event_init']);
Route::get('sample-qrcode', [\App\Http\Controllers\TestController::class, 'sample_qrcode']);
Route::get('print/event-presence/{event_user_id}', [\App\Http\Controllers\Admin\EventPresenceController::class, 'print_event_presence']);
