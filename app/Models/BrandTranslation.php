<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BrandTranslation
 *
 * @property int $id
 * @property int $brand_id
 * @property string $locale
 * @property string $description
 * @method static Builder|BrandTranslation newModelQuery()
 * @method static Builder|BrandTranslation newQuery()
 * @method static Builder|BrandTranslation query()
 * @method static Builder|BrandTranslation whereBrandId($value)
 * @method static Builder|BrandTranslation whereDescription($value)
 * @method static Builder|BrandTranslation whereId($value)
 * @method static Builder|BrandTranslation whereLocale($value)
 * @mixin Eloquent
 */
class BrandTranslation extends Model
{

  /**
   * Not use date create and update
   *
   * @var bool
   */
  public $timestamps = false;

  /**
   * Columns
   *
   * @var string[]
   */
  protected $fillable = [
    'description'
  ];
}
