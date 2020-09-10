<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
  protected $fillable = ['status', 'name', 'sale', 'count_product', 'sale_status']  ;
  protected $casts    = ['status' => 'boolean', 'sale_status' => 'boolean'];

  public function products () {
    return $this->belongsToMany(Product::class,'products_promotions', 'promotion_id', 'product_id');
  }
}
