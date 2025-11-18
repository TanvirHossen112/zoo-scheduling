<?php

namespace App\Http\Requests\V1;

use App\Rules\MaxNumberOfVisitorRule;
use App\Rules\MembershipNumberValidate;
use Illuminate\Foundation\Http\FormRequest;

class VisitorScheduleApiRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'timeslot' => ['required', 'integer', new MaxNumberOfVisitorRule()],
            'visitors.*' => ['required', 'array'],
            'visitors.*.first_name' => ['required', 'string'],
            'visitors.*.last_name' => ['required', 'string'],
            'visitors.*.membership_number' => [
                'bail',
                'nullable',
                'string',
                'regex:/^\d{4}-\d{4}-\d{2}$/',
                'min:12',
                'max:12',
                'unique:visitor_schedules,membership_number',
                new MembershipNumberValidate()
            ],
        ];
    }

    public function authorize(): true
    {
        return true;
    }
}
