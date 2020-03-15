<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
  public function country () {
    return $this->hasOne(Country::class, 'id', 'country_id');
  }
  public function scopeWhereLike($query, $column, $value)
  {
    return $query->where($column, 'like', '%'.$value.'%');
  }
}
