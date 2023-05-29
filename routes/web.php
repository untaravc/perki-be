<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\System\EmailServiceController;

Route::get('/', function (){
    return 'perki-src';
});
Route::get('/panel', [AuthController::class, 'adminPanel']);
Route::get('/panel/{path}', [AuthController::class, 'adminPanel'])->where( 'path' , '([A-z\d\-\/_.]+)?' );

Route::get('login', [AuthController::class, 'login_view']);
Route::post('login', [AuthController::class, 'login']);
Route::get('test-view', [EmailServiceController::class, 'invoice']);

Route::get('event-init', [\App\Http\Controllers\System\EventInitController::class, 'event_init']);
