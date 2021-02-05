<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

//  TODO: Переписать нормально папки

  public function getUrlWebpAttribute(): string
  {
    return asset('storage/images/photos/' . str_replace(" ", "%20", $this->name)  . '.webp');
  }

  public function getThumbnailUrlWebpAttribute(): string
  {
    return asset('storage/images/thumbnails/' . str_replace(" ", "%20", $this->name)  . '.webp');
  }

  public function getUrlJpgAttribute(): string
  {
    return asset('storage/images/photos/' . str_replace(" ", "%20", $this->name)  . '.jpg');
  }

  public function getThumbnailUrlJpgAttribute(): string
  {
    return asset('storage/images/thumbnails/' .  str_replace(" ", "%20", $this->name) . '.jpg');
  }
}
