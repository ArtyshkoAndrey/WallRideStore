<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property bool $on_sale
 * @property bool $on_new
 * @property bool $on_top
 * @property int $sold_count
 * @property string $price
 * @property string|null $price_sale
 * @property string $weight
 * @property object $meta
 * @property int|null $brand_id
 * @property int|null $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\ProductTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Product translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOnNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOnSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOnTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePriceSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSoldCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @metphod static \Illuminate\Database\Eloquent\Builder|Product whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product withTranslation()
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Models\Brand|null $brand
 * @property-read \App\Models\Category|null $category
 * @property-read string $thumbnail_jpg
 * @property-read string $thumbnail_webp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Photo[] $photos
 * @property-read int|null $photos_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductSkus[] $productSkuses
 * @property-read int|null $product_skuses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Skus[] $skuses
 * @property-read int|null $skuses_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTranslationLike(string $translationField, $value, ?string $locale = null)
 */
class Product extends Model implements TranslatableContract
{
  use HasFactory;
  use Translatable;
  use SoftDeletes;

  public array $translatedAttributes = [
    'title',
    'description'
  ];

  protected $fillable = [
    'on_sale',
    'on_new',
    'on_top',
    'sold_count',
    'price',
    'price_sale',
    'weight',
    'meta'
  ];

  protected $casts = [
    'on_sale' => 'boolean',
    'on_new' => 'boolean',
    'on_top' => 'boolean',
    'meta' => 'object'
  ];

  protected $dates = ['deleted_at'];

  protected $attributes = [
    'meta' => '{
      "description": "",
      "title": ""
    }'
  ];

  protected $appends =[
    'thumbnail_webp',
    'thumbnail_jpg'
  ];

  public function available (): bool
  {
    $counter = 0;
    foreach ($this->skus as $sku) {
      $counter += $sku->stock;
    }
    return (boolean) $counter > 0;
  }

  public function category(): BelongsTo
  {
    return $this->belongsTo(Category::class, 'category_id', 'id');
  }

  public function brand(): BelongsTo
  {
    return $this->belongsTo(Brand::class, 'brand_id', 'id');
  }

  public function photos(): HasMany
  {
    return $this->hasMany(Photo::class, 'product_id', 'id');
  }

  public function skuses(): BelongsToMany
  {
    return $this->belongsToMany(Skus::class, 'product_skuses', 'product_id', 'skus_id')->withPivot('stock', 'id');
  }

  public function productSkuses(): HasMany
  {
    return $this->hasMany(ProductSkus::class, 'product_id', 'id');
  }

  public function orders(): BelongsToMany
  {
    return $this->belongsToMany(Order::class, 'order_items', 'product_id', 'order_id')->withPivot(['amount']);
  }

  public function getThumbnailWebpAttribute (): string
  {
    if ($this->photos->count() > 0) {
      return $this->photos->first()->thumbnail_url_webp;
    } else {
      return asset('images/product.jpg');
    }
  }

  public function getThumbnailJpgAttribute (): string
  {
    if ($this->photos->count() > 0) {
      return $this->photos->first()->thumbnail_url_jpg;
    } else {
      return asset('images/product.jpg');
    }
  }

  protected static function booted()
  {
    parent::boot();
    static::deleting(function ($product) {
      if ($product->isForceDeleting()) {
        foreach ($product->photos as $photo) {
          $photo->delete();
        }
      }
    });
  }
}
