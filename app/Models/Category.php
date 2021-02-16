<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property bool $to_menu
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CategoryTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CategoryTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Category translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereToMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category withTranslation()
 * @mixin \Eloquent
 */
class Category extends Model implements TranslatableContract
{
  use HasFactory;
  use Translatable;

  public array $translatedAttributes = [
    'name',
  ];

  protected $fillable = [
    'to_menu',
    'photo'
  ];

  protected $casts = [
    'to_menu' => 'boolean'
  ];


  protected $appends = [
    'search_name'
  ];

  /**
   * Дочерние категории
   *
   * @return BelongsToMany
   */
  public function child(): BelongsToMany
  {
    return $this->belongsToMany(Category::class, 'category_categories', 'category_id', 'child_category_id');
  }

  /**
   * Родительская категория
   *
   * @return BelongsToMany
   */
  public function parents(): BelongsToMany
  {
    return $this->belongsToMany(Category::class, 'category_categories', 'child_category_id', 'category_id');
  }

  public function products(): HasMany
  {
    return $this->hasMany(Product::class);
  }

  public function getSearchNameAttribute (): string
  {
    if ($this->parents()->count() > 0)
      return $this->name . '(' . $this->parents()->first()->name .')';

    if ($this->child()->count() > 0)
      return $this->name . '(' . $this->child()->first()->name .')';

    return '()';
  }

  public function getPhotoStorageAttribute (): string
  {
    if ($this->photo)
      return asset('storage/categories/photo/' . $this->photo);

    return asset('images/product.jpg');
  }
}
