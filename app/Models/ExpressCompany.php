<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpressCompany extends Model
{
 	protected $fillable = [
    'name',
    'enabled',
    'cost',
    'cost_step',
    'step',
    'type'
  ];

  protected $casts = [
    'enables'    => 'boolean'
  ];

  public function cities() {
    return $this->belongsTo(CityExpress::class, 'id', 'express_id');
  }
}
