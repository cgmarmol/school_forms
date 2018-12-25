<?php

namespace App\Models;

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
