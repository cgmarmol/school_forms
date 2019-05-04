<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';

    protected $fillable = [];

    public function person()
    {
      return $this->belongsTo('App\Models\Person');
    }
}
