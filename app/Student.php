<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
      'LRN'
    ];

    public function person()
    {
      return $this->belongsTo('App\Person');
    }
}
