<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\ScheduleController::class, 'index']);
