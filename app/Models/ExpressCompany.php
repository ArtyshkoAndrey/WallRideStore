<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpressCompany extends Model
{
 	protected $fillable = [
    'name',
    'enabled',
    'cast'
  ];

  protected $casts = [
    'enables'    => 'boolean'
  ];
}
