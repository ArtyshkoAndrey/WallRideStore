<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //add this line

class Product extends Model
{
  use SoftDeletes;
  protected $fillable = [
    'title', 'description', 'on_sale',
    'price_sale', 'sold_count', 'price'
  ];
  protected $casts = [
    'on_sale' => 'boolean',
    'on_new' => 'boolean'
  ];

  protected $with = ['photos'];
  protected $dates = ['deleted_at'];

  public function skus ()
  {
    return $this->hasMany(ProductSku::class);
  }

  public function available () {
    $counter = 0;
    foreach ($this->skus as $sku) {
      $counter += $sku->stock;
    }
    return (boolean) $counter > 0;
  }

  public function categories() {
    return $this->belongsToMany(Category::class, 'products_categories', 'product_id', 'category_id');
  }

  public function brands() {
    return $this->belongsToMany(Brand::class, 'products_brands', 'product_id', 'brand_id');
  }

  public function photos() {
    return $this->hasMany(Photo::class, 'product_id', 'id');
  }

  public function scopeZeroSkus($query)
  {
    return $query->whereHas('skus', function ($voteQuery) {
      $voteQuery->where('stock', '=', 0);
    });
  }
}
