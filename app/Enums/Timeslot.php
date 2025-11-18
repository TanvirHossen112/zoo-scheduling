<?php

namespace App\Enums;

enum Timeslot: int
{
    case TEN_TO_TWELVE = 10;
    case TWELVE_TO_FOURTEEN = 12;
    case FOURTEEN_TO_SIXTEEN = 14;
    case SIXTEEN_TO_EIGHTEEN = 16;

    public function label(): string
    {
        return match ($this) {
            self::TWELVE_TO_FOURTEEN => '12:00-14:00',
            self::FOURTEEN_TO_SIXTEEN => '14:00-16:00',
            self::SIXTEEN_TO_EIGHTEEN => '16:00-18:00',
            default => '10:00-12:00',
        };
    }
}
