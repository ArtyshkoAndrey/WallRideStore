<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpressCompany extends Model
{
 	protected $fillable = [
    'name',
    'enabled',
    'cost_type'
  ];

  protected $casts = [
    'enables'    => 'boolean'
  ];

  public function zones() {
    return $this->hasMany(ExpressZone::class, 'company_id', 'id');
  }
}
