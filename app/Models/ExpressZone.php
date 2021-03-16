<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\ExpressZone
 *
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property int|null $cost
 * @property int|null $cost_step
 * @property int|null $step
 * @property array|null $step_cost_array
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|City[] $cities
 * @property-read int|null $cities_count
 * @property-read ExpressCompany $company
 * @method static Builder|ExpressZone newModelQuery()
 * @method static Builder|ExpressZone newQuery()
 * @method static Builder|ExpressZone query()
 * @method static Builder|ExpressZone whereCompanyId($value)
 * @method static Builder|ExpressZone whereCost($value)
 * @method static Builder|ExpressZone whereCostStep($value)
 * @method static Builder|ExpressZone whereCreatedAt($value)
 * @method static Builder|ExpressZone whereId($value)
 * @method static Builder|ExpressZone whereName($value)
 * @method static Builder|ExpressZone whereStep($value)
 * @method static Builder|ExpressZone whereStepCostArray($value)
 * @method static Builder|ExpressZone whereUpdatedAt($value)
 * @mixin Eloquent
 */
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
