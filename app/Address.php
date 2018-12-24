<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
      'description',
      'barangay',
      'municipality_city',
      'province'
    ];
}
