<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\ProductSkus
 *
 * @property int $id
 * @property int $stock
 * @property int $product_id
 * @property int $skus_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Skus|null $skus
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkus query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkus whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkus whereSkusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkus whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
