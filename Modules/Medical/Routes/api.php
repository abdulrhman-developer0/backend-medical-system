<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Medical\Http\Controllers\ClinicController;
use Modules\Medical\Http\Controllers\DoctorController;

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

Route::prefix('/medical')->group(function() {

    Route::apiResource('/clinics', ClinicController::class);

    Route::apiResource('/doctors', DoctorController::class);
});
