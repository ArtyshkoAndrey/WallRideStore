<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property bool $to_menu
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read CategoryTranslation|null $translation
 * @property-read Collection|CategoryTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|Category listsTranslations(string $translationField)
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category notTranslatedIn(?string $locale = null)
 * @method static Builder|Category orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Category orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Category orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Category query()
 * @method static Builder|Category translated()
 * @method static Builder|Category translatedIn(?string $locale = null)
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereToMenu($value)
 * @method static Builder|Category whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Category whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Category whereUpdatedAt($value)
 * @method static Builder|Category withTranslation()
 * @mixin Eloquent
 * @property string|null $photo
 * @property-read Collection|Category[] $child
 * @property-read int|null $child_count
 * @property-read string $photo_storage
 * @property-read string $search_name
 * @property-read Collection|Category[] $parents
 * @property-read int|null $parents_count
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static Builder|Category wherePhoto($value)
 * @method static \Database\Factories\CategoryFactory factory(...$parameters)
 */
class Category extends Model implements TranslatableContract
{
  use HasFactory;
  use Translatable;

  const PHOTO_PATH = 'storage/categories/photo/';
  /**
   * Translate Columns
   *
   * @var array|string[]
   */
  public array $translatedAttributes = [
    'name',
  ];
  /**
   * Columns
   *
   * @var string[]
   */
  protected $fillable = [
    'to_menu',
    'photo'
  ];
  /**
   * Type columns
   *
   * @var string[]
   */
  protected $casts = [
    'to_menu' => 'boolean'
  ];
  /**
   * Set property function
   *
   * @var string[]
   */
  protected $appends = [
    'search_name'
  ];

  /**
   * Products in category
   *
   * @return HasMany
   */
  public function products(): HasMany
  {
    return $this->hasMany(
      Product::class
    );
  }

  /**
   * Name with Parent or Child Category
   *
   * @return string
   */
  public function getSearchNameAttribute(): string
  {
    if ($this->parents()->count() > 0)
      return $this->name . '(' . $this->parents()->first()->name . ')';

    if ($this->child()->count() > 0)
      return $this->name . '(' . $this->child()->first()->name . ')';

    return '';
  }

  /**
   * Parent Categories
   *
   * @return BelongsToMany
   */
  public function parents(): BelongsToMany
  {
    return $this->belongsToMany(
      Category::class,
      'category_categories',
      'child_category_id',
      'category_id'
    );
  }

  /**
   * Child Categories
   *
   * @return BelongsToMany
   */
  public function child(): BelongsToMany
  {
    return $this->belongsToMany(
      Category::class,
      'category_categories',
      'category_id',
      'child_category_id'
    );
  }

  /**
   * Link photo
   *
   * @return string
   */
  public function getPhotoStorageAttribute(): string
  {
    if ($this->photo)
      return asset(Category::PHOTO_PATH . $this->photo);

    return asset('images/product.jpg');
  }

  public function countProducts()
  {
    return $this->products->count() + $this->child()->withCount('products')->get()->sum('products_count');
  }
}
