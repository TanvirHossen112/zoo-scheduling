<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class VisitorScheduleApiRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'timeslot' => ['required', 'integer'],
            'visitors.*' => ['required', 'array'],
            'visitors.*.first_name' => ['required', 'string'],
            'visitors.*.last_name' => ['required', 'string'],
            'visitors.*.membership_number' => ['nullable', 'string'],
        ];
    }

    public function authorize(): true
    {
        return true;
    }
}
