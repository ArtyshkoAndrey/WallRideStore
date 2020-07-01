<?php

namespace App\Models;

use App\Exceptions\InternalException;
use Illuminate\Database\Eloquent\Model;

class Skus extends Model
{
  protected $fillable = ['title', 'skus_category_id', 'weight'];

  public function products()
  {
    return $this->belongsToMany(Product::class, 'product_skus', 'skus_id', 'product_id');
  }

  public function category()
  {
    return $this->belongsTo(SkusCategory::class, 'skus_category_id', 'id', 'skus_categories');
  }

  public function pskus()
  {
    return $this->hasMany(ProductSku::class);
  }
}
