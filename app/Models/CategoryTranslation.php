<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CategoryTranslation
 *
 * @property int $id
 * @property int $category_id
 * @property string $locale
 * @property string $name
 * @method static Builder|CategoryTranslation newModelQuery()
 * @method static Builder|CategoryTranslation newQuery()
 * @method static Builder|CategoryTranslation query()
 * @method static Builder|CategoryTranslation whereCategoryId($value)
 * @method static Builder|CategoryTranslation whereId($value)
 * @method static Builder|CategoryTranslation whereLocale($value)
 * @method static Builder|CategoryTranslation whereName($value)
 * @mixin Eloquent
 */
class CategoryTranslation extends Model
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
    'name',
  ];
}
