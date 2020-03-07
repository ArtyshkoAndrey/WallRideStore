<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes; //add this line

class Product extends Model
{
  use SoftDeletes;
  protected $fillable = [
    'title', 'description', 'image', 'on_sale',
    'rating', 'sold_count', 'review_count', 'price'
  ];
  protected $casts = [
    'on_sale' => 'boolean',
    'on_new' => 'boolean'
  ];
  protected $appends = ['image_url'];
  protected $dates = ['deleted_at'];

  public function skus()
  {
    return $this->hasMany(ProductSku::class);
  }

  public function getImageUrlAttribute()
  {
    if (Str::startsWith($this->attributes['image'], ['http://', 'https://'])) {
      return $this->attributes['image'];
    }
    return \App::make('url')->to('storage/'.$this->attributes['image']);
  }
  public function available () {
    $counter = 0;
    foreach ($this->skus as $sku) {
      $counter += $sku->stock;
    }
    return (boolean) $counter > 0;
//    return $counter;
  }
}
