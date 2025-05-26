<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorReadingController;

 Route::get('/sensor-readings', [SensorReadingController::class, 'index']);
    Route::post('/sensor-readings/store', [SensorReadingController::class, 'store']);
    Route::get('/sensor-readings/{id}', [SensorReadingController::class, 'show']);
    Route::get('/history', [SensorReadingController::class, 'weeklyDate']);
    Route::get('/today', [SensorReadingController::class, 'today']);
    Route::post('/history', [SensorReadingController::class, 'byDate']);
    Route::post('/history/view', [SensorReadingController::class, 'showByDate']);