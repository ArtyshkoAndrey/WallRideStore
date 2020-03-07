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
    'company_id'
  ];

  public function cities() {
//    return $this->hasMany(CityExpress::class, 'express_zone_id', 'id');
    return $this->belongsToMany(City::class, 'city_expresses', 'express_zone_id', 'city_id')->withTimestamps()->orderBy('city_expresses.updated_at', 'DESC');
  }

  public function company() {
    return $this->belongsTo(ExpressCompany::class, 'company_id', 'id');
  }
}
