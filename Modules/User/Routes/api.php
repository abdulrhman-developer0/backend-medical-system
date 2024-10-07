<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/users')->group(function () {

    Route::get('/auth', [AuthController::class, 'index']);
    Route::post('/auth', [AuthController::class, 'store']);
    Route::put('/auth/change-password', [AuthController::class, 'changePassword']);
    Route::delete('/auth', [AuthController::class, 'destroy']);
});
