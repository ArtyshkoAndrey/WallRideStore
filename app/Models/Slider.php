<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Slider
 *
 * @property int $id
 * @property string $url
 * @property string $mobile_photo
 * @property string $photo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $photo_mobile_url_jpg
 * @property-read string $photo_mobile_url_webp
 * @property-read string $photo_url_jpg
 * @property-read string $photo_url_webp
 * @property-read SliderTranslation|null $translation
 * @property-read Collection|SliderTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|Slider listsTranslations(string $translationField)
 * @method static Builder|Slider newModelQuery()
 * @method static Builder|Slider newQuery()
 * @method static Builder|Slider notTranslatedIn(?string $locale = null)
 * @method static Builder|Slider orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Slider orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Slider orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Slider query()
 * @method static Builder|Slider translated()
 * @method static Builder|Slider translatedIn(?string $locale = null)
 * @method static Builder|Slider whereCreatedAt($value)
 * @method static Builder|Slider whereId($value)
 * @method static Builder|Slider whereMobileText($value)
 * @method static Builder|Slider wherePhoto($value)
 * @method static Builder|Slider whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Slider whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Slider whereUpdatedAt($value)
 * @method static Builder|Slider whereUrl($value)
 * @method static Builder|Slider withTranslation()
 * @mixin Eloquent
 * @method static Builder|Slider whereMobilePhoto($value)
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
    'photo_url_jpg',
    'photo_mobile_url_jpg',
    'photo_url_webp',
    'photo_mobile_url_webp'
  ];

  const PHOTO_PATH = 'storage/slider/photos/';
  const PHOTO_PATH_MOBILE = 'storage/slider/mobile/';

  public function getPhotoUrlJpgAttribute(): string
  {
    return asset(Slider::PHOTO_PATH . $this->photo . '.jpg');
  }

  public function getPhotoMobileUrlJpgAttribute(): string
  {
    return asset(Slider::PHOTO_PATH_MOBILE . $this->mobile_photo . '.jpg');
  }

  public function getPhotoUrlWebpAttribute(): string
  {
    return asset(Slider::PHOTO_PATH . $this->photo . '.webp');
  }

  public function getPhotoMobileUrlWebpAttribute(): string
  {
    return asset(Slider::PHOTO_PATH_MOBILE . $this->mobile_photo . '.webp');
  }
}
