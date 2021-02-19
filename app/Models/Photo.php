<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Photo
 *
 * @property int $id
 * @property int|null $product_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $thumbnail_url_jpg
 * @property-read string $thumbnail_url_webp
 * @property-read string $url_jpg
 * @property-read string $url_webp
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Photo extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
  ];

  /**
   * @var string
   */
  const PHOTO_PATH = 'storage/products/photos/';

  /**
   * @var string
   */
  const THUMBNAIL_PATH = 'storage/products/thumbnails/';

  public function product(): BelongsTo
  {
    return $this->belongsTo(Product::class, 'product_id', 'id')->withTrashed();
  }

  protected $appends = [
    'thumbnail_url_webp',
    'url_webp',
    'url_jpg',
    'thumbnail_url_jpg'
  ];


  public function getUrlWebpAttribute(): string
  {
    return asset(Photo::PHOTO_PATH . str_replace(" ", "%20", $this->name)  . '.webp');
  }

  public function getThumbnailUrlWebpAttribute(): string
  {
    return asset(Photo::THUMBNAIL_PATH . str_replace(" ", "%20", $this->name)  . '.webp');
  }

  public function getUrlJpgAttribute(): string
  {
    return asset(Photo::PHOTO_PATH . str_replace(" ", "%20", $this->name)  . '.jpg');
  }

  public function getThumbnailUrlJpgAttribute(): string
  {
    return asset(Photo::THUMBNAIL_PATH .  str_replace(" ", "%20", $this->name) . '.jpg');
  }
}
