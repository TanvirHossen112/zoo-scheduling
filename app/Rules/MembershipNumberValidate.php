<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MembershipNumberValidate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $string_parts = explode('-', $value);
        $first_part = (int)($string_parts[0] . $string_parts[1]);
        $mod = $first_part % 97;
        $last_part = (int)$string_parts[2];
        if ($mod !== $last_part) {
            $fail('The :attribute is invalid.');
        }
    }
}
