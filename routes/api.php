<?php

use App\Http\Actions\V1\AvailableTimeSlotController;
use App\Http\Controllers\ScheduleController;

Route::group(['prefix' => 'v1'], function () {
    Route::get('/available-timeslots', AvailableTimeSlotController::class);

    Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');
});
