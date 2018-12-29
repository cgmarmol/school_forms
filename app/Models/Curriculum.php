<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    protected $table = 'curricula';

    protected $fillable = [
      'course_code',
      'description',
      'academic_year_effectivity'
    ];
}
