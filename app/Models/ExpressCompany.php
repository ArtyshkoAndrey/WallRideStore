<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpressCompany extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'enabled',
    'track_url',
    'min_cost',
    'enabled_cash',
    'enabled_card'
  ];

  protected $casts = [
    'enabled' => 'boolean',
    'enabled_cash' => 'boolean',
    'enabled_card' => 'boolean'
  ];

  public function zones(): HasMany
  {
    return $this->hasMany(ExpressZone::class, 'company_id', 'id');
  }

  public function cities(): BelongsToMany
  {
    return $this->belongsToMany(City::class, 'city_expresses', 'express_company_id', 'city_id');
  }
}
