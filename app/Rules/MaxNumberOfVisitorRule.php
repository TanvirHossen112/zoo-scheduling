<?php

namespace App\Rules;

use App\Services\ScheduleAggregator;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class MaxNumberOfVisitorRule implements ValidationRule
{
    /**
     * @param string $attribute
     * @param $value
     * @param Closure $fail
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function validate(string $attribute, $value, Closure $fail): void
    {
        $date = request()->get('date');
        $timeslot = $value;
        $total_visitor = ScheduleAggregator::dateAndTimeSlotWiseCount($date, $timeslot);
        if ($total_visitor >= 200) {
            $fail('Number of visitors cannot exceed 200 for this time slot.');
        }
    }
}
