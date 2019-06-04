<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
      'LRN'
    ];

    public function person()
    {
      return $this->belongsTo('App\Models\Person');
    }

    public function sections() {
      return $this->belongsToMany('App\Models\Section');
    }
    
    public function attendances() {
      return $this->hasMany('App\Models\Attendance');
    }
    
    
    
}
