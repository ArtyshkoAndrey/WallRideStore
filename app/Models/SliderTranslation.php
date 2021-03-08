<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
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
 * @method static Builder|SliderTranslation newModelQuery()
 * @method static Builder|SliderTranslation newQuery()
 * @method static Builder|SliderTranslation query()
 * @method static Builder|SliderTranslation whereBtnText($value)
 * @method static Builder|SliderTranslation whereH1($value)
 * @method static Builder|SliderTranslation whereH2($value)
 * @method static Builder|SliderTranslation whereId($value)
 * @method static Builder|SliderTranslation whereLocale($value)
 * @method static Builder|SliderTranslation whereSliderId($value)
 * @mixin Eloquent
 */
class SliderTranslation extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $fillable = [
    'h1',
    'h2',
    'btn_text'
  ];
}
