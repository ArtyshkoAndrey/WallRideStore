<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|City[] $cities
 * @property-read int|null $cities_count
 * @property-read Collection|ExpressZone[] $zones
 * @property-read int|null $zones_count
 * @method static Builder|ExpressCompany newModelQuery()
 * @method static Builder|ExpressCompany newQuery()
 * @method static Builder|ExpressCompany query()
 * @method static Builder|ExpressCompany whereCreatedAt($value)
 * @method static Builder|ExpressCompany whereEnabled($value)
 * @method static Builder|ExpressCompany whereEnabledCard($value)
 * @method static Builder|ExpressCompany whereEnabledCash($value)
 * @method static Builder|ExpressCompany whereId($value)
 * @method static Builder|ExpressCompany whereMinCost($value)
 * @method static Builder|ExpressCompany whereName($value)
 * @method static Builder|ExpressCompany whereTrackUrl($value)
 * @method static Builder|ExpressCompany whereUpdatedAt($value)
 * @mixin Eloquent
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
    'enabled_card',
    'description'
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
