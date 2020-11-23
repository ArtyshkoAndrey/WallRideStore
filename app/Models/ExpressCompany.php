<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpressCompany extends Model
{
 	protected $fillable = [
    'name',
    'enabled',
    'cost_type',
    'track_code',
    'min_cost',
    'enabled_cash',
    'enabled_card'
  ];

  protected $casts = [
    'enabled'      => 'boolean',
    'enabled_cash' => 'boolean',
    'enabled_card' => 'boolean'
  ];

  public function zones() {
    return $this->hasMany(ExpressZone::class, 'company_id', 'id');
  }

  public function cities () {
    return $this->belongsToMany(City::class, 'city_expresses', 'express_company_id', 'city_id');
  }
}
