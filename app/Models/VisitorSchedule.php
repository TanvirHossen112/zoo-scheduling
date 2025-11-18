<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorSchedule extends Model
{
    protected $table = 'visitor_schedules';
    protected $fillable = [
        'uuid',
        'date',
        'timeslot',
        'first_name',
        'last_name',
        'membership_number'
    ];
}
