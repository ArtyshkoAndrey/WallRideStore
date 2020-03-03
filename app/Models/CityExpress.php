<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityExpress extends Model
{
  protected $fillable = [
  ];

  public function name() {
    return $this->belongsTo(City::class, 'id', 'city_id');
  }
}
