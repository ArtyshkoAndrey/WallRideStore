<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\CityExpress
 *
 * @property int $id
 * @property int $express_zone_id
 * @property int $city_id
 * @property int $express_company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\City|null $cityOriginal
 * @method static \Illuminate\Database\Eloquent\Builder|CityExpress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CityExpress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CityExpress query()
 * @method static \Illuminate\Database\Eloquent\Builder|CityExpress whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityExpress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityExpress whereExpressCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityExpress whereExpressZoneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityExpress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityExpress whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CityExpress extends Model
{
  use HasFactory;

  public function cityOriginal(): HasOne
  {
    return $this->hasOne(City::class, 'id', 'city_id');
  }
}
