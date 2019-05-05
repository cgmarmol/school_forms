<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnrollmentSchedule extends Model
{
    protected $table = 'enrollment_schedules';

    protected $fillable = [
      'academic_year',
      'semester',
      'start_date',
      'end_date'
    ];
}
