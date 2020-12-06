<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

  public function scopeWhereLike ($query, $column, $value)
  {
    return $query->where($column, 'like', '%'.$value.'%');
  }

  public function cities () {
    return $this->hasMany(City::class, 'country_id', 'id');
  }
}
