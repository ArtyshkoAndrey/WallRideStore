<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityExpress extends Model
{
  
  public function cityOriginal() {
    return $this->hasOne(City::class, 'id', 'city_id');
  }
}
