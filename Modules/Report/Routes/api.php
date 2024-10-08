<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Report\Http\Controllers\ReportController;

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
    'prefix'        => '/reports',
    // 'middleware'    => ['auth:sanctum']
], function() {


    Route::get('/doctors', [ReportController::class, 'doctors']);

    Route::get('/patients', [ReportController::class, 'patients']);

    Route::get('/services', [ReportController::class, 'services']);
});
