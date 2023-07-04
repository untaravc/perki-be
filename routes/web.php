<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\System\EmailServiceController;

Route::get('/', function (){
    return 'perki-src';
});
Route::get('/panel/print-abstract', [PostController::class, 'printPost']);
Route::get('/panel', [AuthController::class, 'adminPanel']);
Route::get('/panel/{path}', [AuthController::class, 'adminPanel'])->where( 'path' , '([A-z\d\-\/_.]+)?' );

Route::get('login', [AuthController::class, 'login_view']);
Route::post('login', [AuthController::class, 'login']);
Route::get('test-view', [\App\Http\Controllers\User\AuthController::class, 'send_new_password']);

Route::get('event-init', [\App\Http\Controllers\System\EventInitController::class, 'event_init']);
