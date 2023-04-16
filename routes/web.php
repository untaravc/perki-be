<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;

Route::get('/', function (){
    return 'perki-src';
});
Route::get('/panel', [AuthController::class, 'adminPanel']);
Route::get('/panel/{path}', [AuthController::class, 'adminPanel'])->where( 'path' , '([A-z\d\-\/_.]+)?' );

//Route::fallback([AuthController::class, 'notFound']);
