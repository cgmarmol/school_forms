<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'sections';

    protected $fillable = [
        'academic_year',
        'semester',
        'name',
        'subject_id'
    ];

    public function students()
    {
        return $this->belongsToMany('App\Models\Student', 'section_student', 'section_id', 'student_id')
          ->withPivot(['grade'])
          ->withTimestamps();
    }

    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }
}
