<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Brand
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BrandTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BrandTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Brand listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand withTranslation()
 * @mixin \Eloquent
 */
class Brand extends Model implements TranslatableContract
{
  use HasFactory;
  use Translatable;

  public array $translatedAttributes = [
    'description'
  ];

  protected $fillable = [
    'name',
    'logo',
    'photo',
    'to_index'
  ];

  protected $casts = [
    'to_index' => 'boolean'
  ];

  public function products (): HasMany
  {
    return $this->hasMany(Product::class);
  }

  public function getPhotoJpgStorageAttribute (): string
  {
    if ($this->photo) {
      return asset('storage/brands/photo/' . $this->photo . '.jpg');
    }

    return asset('images/product.jpg');
  }

  public function getPhotoWebpStorageAttribute (): string
  {
    if ($this->photo) {
      return asset('storage/brands/photo/' . $this->photo . '.webp');
    }

    return asset('images/product.jpg');
  }

  public function getLogoJpgStorageAttribute (): string
  {
    if ($this->logo)
      return asset('storage/brands/logo/' . $this->logo . '.jpg');

    return asset('images/product.jpg');
  }

  public function getLogoWebpStorageAttribute (): string
  {
    if ($this->logo)
      return asset('storage/brands/logo/' . $this->logo . 'webp');

    return asset('images/product.jpg');
  }
}
