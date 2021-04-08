<?php

namespace App\Models;

use Database\Factories\BrandFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Brand
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read BrandTranslation|null $translation
 * @property-read Collection|BrandTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|Brand listsTranslations(string $translationField)
 * @method static Builder|Brand newModelQuery()
 * @method static Builder|Brand newQuery()
 * @method static Builder|Brand notTranslatedIn(?string $locale = null)
 * @method static Builder|Brand orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Brand orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Brand orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Brand query()
 * @method static Builder|Brand translated()
 * @method static Builder|Brand translatedIn(?string $locale = null)
 * @method static Builder|Brand whereCreatedAt($value)
 * @method static Builder|Brand whereId($value)
 * @method static Builder|Brand whereName($value)
 * @method static Builder|Brand whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Brand whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Brand whereUpdatedAt($value)
 * @method static Builder|Brand withTranslation()
 * @mixin Eloquent
 * @property string|null $logo
 * @property string|null $photo
 * @property string|null $logo_path
 * @property string|null $photo_path
 * @property bool $to_index
 * @property-read string $logo_jpg_storage
 * @property-read string $logo_webp_storage
 * @property-read string $photo_jpg_storage
 * @property-read string $photo_webp_storage
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static Builder|Brand whereLogo($value)
 * @method static Builder|Brand wherePhoto($value)
 * @method static Builder|Brand whereToIndex($value)
 * @method static BrandFactory factory(...$parameters)
 */
class Brand extends Model implements TranslatableContract
{
  use HasFactory;
  use Translatable;

  /**
   * @var string
   */
  const PHOTO_PATH = 'storage/brands/photo/';

  /**
   * @var string
   */
  const LOGO_PATH = 'storage/brands/logo/';

  /**
   * Translate column
   *
   * @var array|string[]
   */
  public array $translatedAttributes = [
    'description'
  ];

  /**
   * Columns
   *
   * @var string[]
   */
  protected $fillable = [
    'name',
    'logo',
    'photo',
    'to_index'
  ];

  /**
   * Type columns
   *
   * @var string[]
   */
  protected $casts = [
    'to_index' => 'boolean'
  ];

  /**
   * Products in brand
   *
   * @return HasMany
   */
  public function products (): HasMany
  {
    return $this->hasMany(
      Product::class
    );
  }

  /**
   * Photo jpg type
   *
   * @return string
   */
  public function getPhotoJpgStorageAttribute (): string
  {
    if ($this->photo) {
      return asset(self::PHOTO_PATH . $this->photo . '.jpg');
    }

    return asset('images/product.jpg');
  }

  /**
   * Photo webp type
   *
   * @return string
   */
  public function getPhotoWebpStorageAttribute (): string
  {
    if ($this->photo) {
      return asset(self::PHOTO_PATH . $this->photo . '.webp');
    }

    return asset('images/product.jpg');
  }

  /**
   * Logo jpg type
   *
   * @return string
   */
  public function getLogoJpgStorageAttribute (): string
  {
    if ($this->logo)
      return asset(self::LOGO_PATH . $this->logo . '.jpg');

    return asset('images/product.jpg');
  }

  /**
   * Logo webp type
   *
   * @return string
   */
  public function getLogoWebpStorageAttribute (): string
  {
    if ($this->logo)
      return asset(self::LOGO_PATH . $this->logo . 'webp');

    return asset('images/product.jpg');
  }
}
