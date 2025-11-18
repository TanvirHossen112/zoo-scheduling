<?php

namespace App\Services;

use App\Models\VisitorSchedule;

class ScheduleAggregator
{
    public static function dateAndTimeSlotWiseCount($date, $timeSlot)
    {
//
    }

    public static function dateWiseTimeslotCount($date)
    {
        return VisitorSchedule::selectRaw('COUNT(*) as count, timeslot')
            ->where('date', $date)->groupBy('timeslot')->get()->keyBy('timeslot')->toArray();
    }

    public static function dateWiseScheduleCount($startDate, $endDate)
    {
        return VisitorSchedule::selectRaw('COUNT(*) as count, date')
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy('date')->get()
            ->keyBy('date')->toArray();
    }
}
