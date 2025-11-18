<?php

namespace App\Http\Resources\V1;

use App\Enums\Timeslot;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VisitorScheduleResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $data = $this->resource;

        $date = array_first($data)['date'];
        $timeslot = array_first($data)['timeslot'];
        $visitors = [];

        foreach ($data as $fields) {
            $visitors[] = [
                'first_name' => $fields['first_name'],
                'last_name' => $fields['last_name'],
                'membership_number' => $fields['membership_number'],
            ];
        }

        return [
            'date' => $date,
            'timeslot' => $timeslot,
            'timeslot_label' => Timeslot::from($timeslot)->label(),
            'visitors' => $visitors,
        ];
    }
}
