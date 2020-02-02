<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
      'title', 'description', 'image', 'on_sale',
      'rating', 'sold_count', 'review_count', 'price'
    ];
    protected $casts = [
      'on_sale' => 'boolean',
      'on_new' => 'boolean'
    ];
    protected $appends = ['image_url'];
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
}
