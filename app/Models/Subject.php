<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';

    protected $fillable = [
      'level',
      'default_semester',
      'code',
      'title',
      'description'
    ];
    
    public function sections()
    {
       return $this->hasMany('App\Models\Section');
    }
}
