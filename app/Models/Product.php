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

  public function promotions () {
    return $this->belongsToMany(Promotion::class, 'products_promotions', 'product_id', 'promotion_id');
  }

  static function getProducts ($ids) {
    $products = [];
    $promotions = [];
    foreach ($ids as $k => $id) {
      $productSku = ProductSku::with('product')->find((int) $id);
      array_push($products, $productSku);
      foreach(Promotion::all() as $pr) {
        if ($pr->products()->where('product_id', $productSku->product->id)->exists()) {
          if (isset($promotions[$pr->id])) {
            array_push($promotions[$pr->id], $productSku);
          } else {
            $promotions[$pr->id] = [];
            array_push($promotions[$pr->id], $productSku);
          }
        }
      }
    }
//    Код для акции где скидка на второй товар.
    if (isset($promotions[1]) && ($promotion = Promotion::find(1))->status === true) {
      $p = null;
      if (($countFromFirst = (int)(count($promotions[1]) / 2)) > 0) {
        while ($countFromFirst > 0) {
          $minCost = PHP_INT_MAX;
          foreach ($promotions[1] as $productSku) {
            $price = (int)$productSku->product->price;

            if ($minCost > $price && !isset($productSku->product->isPromotion)) {
              $minCost = $productSku->product->price;
              $p = $productSku;
              $productSku->product->isPromotion = true;
            }
          }
          for ($i = 0; $i < count($products); $i++) {
            if ($products[$i] == $p) {
              $productSku = (object)$products[$i]->toArray();
              $productSku->product = (object)$productSku->product;
              for ($j = 0; $j < count($productSku->product->photos); $j++) {
                $productSku->product->photos[$j] = (object)$productSku->product->photos[$j];
              }
              $productSku->product->price = (int)$productSku->product->price - (int)$productSku->product->price * (int)$promotion->sale / 100;
              $productSku->product->isPromotion = true;
              $products[$i] = $productSku;
              break;
            }
          }
          $countFromFirst--;
        }
      }
    }
    return $products;

  }
}
