<?php

namespace App\Models;

use App\Services\CartService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
  use SoftDeletes;
  protected $fillable = [
    'title', 'description', 'on_sale',
    'price_sale', 'sold_count', 'price',
    'meta', 'on_top', 'on_new'
  ];
  protected $casts = [
    'on_sale' => 'boolean',
    'on_new'  => 'boolean',
    'on_top'  => 'boolean',
    'meta'    => 'object'
  ];

  protected $with  = ['photos', 'promotions', 'skus'];
  protected $dates = ['deleted_at'];

  public function skus ()
  {
    return $this->hasMany(ProductSku::class);
  }

  public function getTop () {
    $pr = $this->where('on_top', true)->orderBy('created_at', 'desc')->with('skus', 'photos')->whereHas('skus', function($sku) {
      return $sku->where('stock', '>', '0');
    })->take(5)->get();
    if ($pr->count() > 0) {
      return $pr;
    }
    $pr = $this->orderBy('sold_count', 'desc')->with('skus', 'photos')->whereHas('skus', function($sku) {
      return $sku->where('stock', '>', '0');
    })->take(5)->get();
    return $pr;
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

  static function getProducts ($ids)
  {
    $products   = [];
    $promotions = [];
    if (count($ids) > 0 && $ids[0] !== '') {
      foreach ($ids as $k => $id) {
        $productSku = ProductSku::with('product', 'skus')->find((int)$id);
        if (!Auth::check()) {
          if (!isset($productSku)  || !isset($productSku->product)) {
            unset($ids[$k]);
            break;
          }
        } else {
          if(!$productSku || !$productSku->product || $productSku === null) {
            app(CartService::class)->remove($id);
            unset($ids[$k]);
            break;
          }
        }
        array_push($products, $productSku);
        foreach (Promotion::all() as $pr) {
          if ($pr->products()->where('product_id', $productSku->product->id)->exists()) {
            if ($productSku->product->on_sale) {
              if ($productSku->product->on_sale && $pr->sale_status) {
                if (isset($promotions[$pr->id])) {
                  array_push($promotions[$pr->id], $productSku);
                } else {
                  $promotions[$pr->id] = [];
                  array_push($promotions[$pr->id], $productSku);
                }
              }
            } else {
              if (isset($promotions[$pr->id])) {
                array_push($promotions[$pr->id], $productSku);
              } else {
                $promotions[$pr->id] = [];
                array_push($promotions[$pr->id], $productSku);
              }
            }
          }
        }
      }
      //    Код для акции где скидка на второй товар.
      foreach (Promotion::all() as $promotion) {
        if (isset($promotions[$promotion->id]) && $promotion->status === true) {
          $p = null;
          if (($countFromFirst = (int)(count($promotions[$promotion->id]) / $promotion->count_product)) > 0) {
            while ($countFromFirst > 0) {
              $minCost = PHP_INT_MAX;
              foreach ($promotions[$promotion->id] as $productSku) {
                $price = $productSku->product->on_sale ? (int)$productSku->product->price_sale : (int)$productSku->product->price;

                if ($minCost > $price && !isset($productSku->product->isPromotion)) {
                  $minCost = $price;
                  $p       = $productSku;
                }
              }
              for ($i = 0; $i < count($products); $i++) {
                if ($products[$i] == $p) {
                  $productSku          = (object) $products[$i]->toArray();
                  $productSku->product = (object) $productSku->product;
                  if ($productSku->skus !== null)
                    $productSku->skus = (object) $productSku->skus;

                  for ($j = 0; $j < count($productSku->product->photos); $j++) {
                    $productSku->product->photos[$j] = (object) $productSku->product->photos[$j];
                  }
                  $productSku->product->price         = (int) $productSku->product->price - (int) $productSku->product->price * (int)$promotion->sale / 100;
                  $productSku->product->price_sale    = (int) $productSku->product->price_sale - (int) $productSku->product->price_sale * (int)$promotion->sale / 100;
                  $productSku->product->isPromotion   = true;
                  $productSku->product->namePromotion = $promotion->name;
                  $products[$i]                       = $productSku;
                  break;
                }
              }
              $countFromFirst--;
            }
          }
        }
      }
    }
    return $products;
  }
}
