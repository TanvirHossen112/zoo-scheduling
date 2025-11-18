<?php

namespace App\Http\Actions\V1;

use App\Models\VisitorSchedule;
use Illuminate\Support\Str;

class VisitorScheduleAction
{
    /**
     * Execute the action
     *
     * @param array $fields
     * @return array
     */
    public function execute(array $fields): array
    {
        $uuid = Str::uuid();
        $visitors = $fields['visitors'];
        $formattedSchedule = [];

        foreach ($visitors as $visitor) {

            $formattedSchedule[] = [
                'uuid' => $uuid,
                'date' => $fields['date'],
                'timeslot' => $fields['timeslot'],
                'first_name' => $visitor['first_name'],
                'last_name' => $visitor['last_name'] ?? null,
                'membership_number' => $visitor['membership_number'] ?? null,
                'created_at' => now(),
            ];

        }

        VisitorSchedule::insert($formattedSchedule);

        return $formattedSchedule;
    }
}
