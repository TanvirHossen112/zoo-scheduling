<?php

namespace App\Http\Controllers;

use App\Enums\Timeslot;
use App\Services\ScheduleAggregator;
use Illuminate\Http\Request;

class AvailableTimeSlotController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function __invoke(Request $request)
    {
        $date = $request->get('date');

        $timeSlotScheduleCounts = ScheduleAggregator::dateWiseTimeslotCount($date);
        $availableTimeSlots = [];
        foreach (array_column(Timeslot::cases(), 'value') as $timeSlot) {
            if (isset($timeSlotScheduleCounts[$timeSlot]) && $timeSlotScheduleCounts[$timeSlot]['count'] >= 200) {
                continue;
            }
            $availableTimeSlots[$timeSlot] = Timeslot::from($timeSlot)->label();
        }
        return $availableTimeSlots;
    }
}
