<?php

namespace App\Services;

use App\Models\VisitorSchedule;

class ScheduleAggregator
{
    /**
     * @param $date
     * @param $timeSlot
     * @return int
     */
    public static function dateAndTimeSlotWiseCount($date, $timeSlot): int
    {
        return VisitorSchedule::where('date', $date)->where('timeslot', $timeSlot)->count();
    }

    /**
     * Get the count of timeslots for a given date
     *
     * @param $date
     * @return array
     */
    public static function dateWiseTimeslotCount($date): array
    {
        return VisitorSchedule::selectRaw('COUNT(*) as count, timeslot')
            ->where('date', $date)->groupBy('timeslot')->get()->keyBy('timeslot')->toArray();
    }

    /**
     * Get the count of schedules for a given date range
     *
     * @param $startDate
     * @param $endDate
     * @return array
     */
    public static function dateWiseScheduleCount($startDate, $endDate): array
    {
        return \DB::select("
            WITH RECURSIVE date_range AS (
                SELECT CAST('$startDate' AS DATE) AS start_date
                UNION ALL
                SELECT start_date + INTERVAL 1 DAY
                FROM date_range
                WHERE start_date < CAST('$endDate' AS DATE)
            )
            SELECT date_range.start_date AS date,
            COALESCE(visitor.number_of_visitors, 0) AS visitor_count
            FROM date_range
            LEFT JOIN (
                SELECT date, COUNT(*) AS number_of_visitors
                FROM visitor_schedules
                WHERE date BETWEEN '$startDate' AND '$endDate'
                GROUP BY date
            ) visitor ON visitor.date = date_range.start_date
        ");
    }
}
