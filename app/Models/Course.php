<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
      'code',
      'description'
    ];

    public function curricula()
    {
	return $this->hasMany('App\Models\Curriculum', 'course_code', 'code');
    }
}
