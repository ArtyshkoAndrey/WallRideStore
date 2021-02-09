<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

/**
 * App\Models\Slider
 *
 * @property int $id
 * @property string $url
 * @property string $mobile_text
 * @property string $photo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $photo_mobile_url
 * @property-read string $photo_url
 * @property-read \App\Models\SliderTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SliderTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Slider listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Slider query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereMobileText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider withTranslation()
 * @mixin \Eloquent
 */
class Slider extends Model implements TranslatableContract
{
  use HasFactory;
  use Translatable;

  public array $translatedAttributes = [
    'h1',
    'h2',
    'btn_text'
  ];

  protected $fillable = [
    'url',
    'photo',
    'mobile_photo',
  ];

  protected $appends = [
    'photo_url',
    'photo_mobile_url'
  ];

  public function getPhotoUrlAttribute (): string
  {
    return storage_path('storage/slider/photos/' . $this->photo);
  }

  public function getPhotoMobileUrlAttribute (): string
  {
    return storage_path('storage/slider/mobile/' . $this->mobile_photo);
  }
}
