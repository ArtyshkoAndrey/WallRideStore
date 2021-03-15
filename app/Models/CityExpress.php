<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CityExpress extends Model
{
  use HasFactory;

  public function cityOriginal(): HasOne
  {
    return $this->hasOne(City::class, 'id', 'city_id');
  }
}
