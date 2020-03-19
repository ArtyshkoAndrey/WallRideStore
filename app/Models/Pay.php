<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
  protected $fillable = [
    'pg_merchant_id', 'pg_testing_mode', 'pg_description', 'url', 'code', 'name'
  ];
  protected $casts = [
    'pg_testing_mode' => 'boolean',
  ];
}
