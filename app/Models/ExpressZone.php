<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ExpressZone extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'cost',
    'cost_step',
    'step',
    'company_id',
    'step_cost_array'
  ];

  protected $casts = [
    'step_cost_array' => 'json'
  ];

  public function cities(): BelongsToMany
  {
    return $this->belongsToMany(City::class, 'city_expresses', 'express_zone_id', 'city_id')->withTimestamps()->orderBy('city_expresses.updated_at', 'DESC');
  }

  public function company(): BelongsTo
  {
    return $this->belongsTo(ExpressCompany::class, 'company_id', 'id');
  }
}
