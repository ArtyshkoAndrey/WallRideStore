<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ExpressCompany
 *
 * @property int $id
 * @property string $name
 * @property bool $enabled
 * @property string|null $track_url
 * @property int $min_cost
 * @property bool $enabled_cash
 * @property bool $enabled_card
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 * @property-read int|null $cities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExpressZone[] $zones
 * @property-read int|null $zones_count
 * @method static \Illuminate\Database\Eloquent\Builder|ExpressCompany newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpressCompany newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpressCompany query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpressCompany whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpressCompany whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpressCompany whereEnabledCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpressCompany whereEnabledCash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpressCompany whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpressCompany whereMinCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpressCompany whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpressCompany whereTrackUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpressCompany whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
