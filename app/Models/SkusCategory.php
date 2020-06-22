<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkusCategory extends Model
{
  protected $fillable = ['name'];

  public function skuses () {
    return $this->hasMany('App\Models\Skus');
  }
}
