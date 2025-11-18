<?php

use App\Http\Controllers\DailyVisitorGraphController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ScheduleController::class, 'index'])->name('schedule.index');
Route::get('/visitors/daily', [DailyVisitorGraphController::class, 'index'])->name('visitors.daily');
