<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductSkus extends Model
{
  use HasFactory;

  protected $fillable = [
    'stock',
    'skus_id',
  ];

  public function skus (): HasOne
  {
    return $this->hasOne(Skus::class, 'id', 'skus_id');
  }

  public function product (): HasOne
  {
    return $this->hasOne(Product::class, 'id', 'product_id');
  }
}
