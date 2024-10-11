<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Medical\Http\Controllers\AppointmentController;
use Modules\Medical\Http\Controllers\ClinicController;
use Modules\Medical\Http\Controllers\DiagnosisController;
use Modules\Medical\Http\Controllers\DoctorController;
use Modules\Medical\Http\Controllers\NationalityController;
use Modules\Medical\Http\Controllers\PatientController;
use Modules\Medical\Http\Controllers\ServiceController;
use Modules\Medical\Http\Controllers\SettingController;
use Modules\Medical\Http\Controllers\SpecialtyController;
use Modules\Medical\Http\Controllers\StatController;

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

Route::group([
    'prefix'        => '/medical',
    'middleware'    => ['auth:sanctum']
], function () {

    Route::get('/stats', [StatController::class, 'stats'])
        ->middleware(['type:admin']);


    Route::get('/settings', [SettingController::class, 'index']);
    Route::put('/settings', [SettingController::class, 'update'])
        ->middleware(['type:admin']);

    Route::apiResource('/clinics', ClinicController::class);

    Route::apiResource('/services', ServiceController::class);

    Route::apiResource('/specialties', SpecialtyController::class);

    Route::apiResource('/doctors', DoctorController::class);

    Route::apiResource('/patients', PatientController::class);


    Route::get('/nationalities', NationalityController::class);

    Route::apiResource('/appointments', AppointmentController::class);
    Route::patch('/appointments/{id}/status', [AppointmentController::class, 'updateStatus'])
        ->middleware(['type:reception,doctor']);

    Route::patch('/appointments/{id}/discount', [AppointmentController::class, 'discount'])
        ->middleware(['type:admin']);

    Route::apiResource('/diagnosises', DiagnosisController::class);
});
