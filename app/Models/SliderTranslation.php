<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SliderTranslation
 *
 * @property int $id
 * @property int $slider_id
 * @property string $locale
 * @property string $h1
 * @property string $h2
 * @property string $btn_text
 * @method static \Illuminate\Database\Eloquent\Builder|SliderTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SliderTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SliderTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|SliderTranslation whereBtnText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderTranslation whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderTranslation whereH2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderTranslation whereSliderId($value)
 * @mixin \Eloquent
 */
class SliderTranslation extends Model
{
  use HasFactory;

  protected $fillable = [
    'h1',
    'h2',
    'btn_text'
  ];
}
