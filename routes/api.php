<?php

use App\Http\Controllers\AvailableTimeSlotController;
use App\Http\Controllers\ScheduleController;

Route::group(['prefix' => 'v1'], function () {
    Route::get('/available-timeslots', AvailableTimeSlotController::class);

    Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');
});
