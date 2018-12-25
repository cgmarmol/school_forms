<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'people';

    protected $fillable = [
      'first_name',
      'middle_name',
      'last_name',
      'name_extension',
      'gender'
    ];

    public function student()
    {
      return $this->hasOne('App\Models\Student', 'person_id', 'id');
    }

    public function addresses()
    {
      return $this->hasMany('App\Models\Address', 'person_id', 'id');
    }
}
