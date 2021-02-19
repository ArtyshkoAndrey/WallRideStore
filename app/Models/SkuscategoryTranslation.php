<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SkuscategoryTranslation
 *
 * @property int $id
 * @property int $skuscategory_id
 * @property string $locale
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|SkuscategoryTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkuscategoryTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkuscategoryTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|SkuscategoryTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkuscategoryTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkuscategoryTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkuscategoryTranslation whereSkuscategoryId($value)
 * @mixin \Eloquent
 */
class SkuscategoryTranslation extends Model
{
  public $timestamps = false;

  protected $fillable = [
    'name'
  ];
}
