<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpressZone extends Model
{
  protected $fillable = [
    'name',
    'cost',
    'cost_step',
    'step',
  ];

  public function cities() {
    return $this->hasMany(CityExpress::class, 'express_zone_id', 'id');
  }
}
