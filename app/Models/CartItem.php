<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\CartItem
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_sku_id
 * @property int $amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Product $product
 * @property-read User $user
 * @method static Builder|CartItem newModelQuery()
 * @method static Builder|CartItem newQuery()
 * @method static Builder|CartItem query()
 * @method static Builder|CartItem whereAmount($value)
 * @method static Builder|CartItem whereCreatedAt($value)
 * @method static Builder|CartItem whereId($value)
 * @method static Builder|CartItem whereProductSkuId($value)
 * @method static Builder|CartItem whereUpdatedAt($value)
 * @method static Builder|CartItem whereUserId($value)
 * @mixin Eloquent
 * @property-read \App\Models\ProductSkus $product_skus
 */
class CartItem extends Model
{
  use HasFactory;

  /**
   * Columns
   *
   * @var string[]
   */
  protected $fillable = [
    'amount',
  ];

  /**
   * Product in cart
   *
   * @return BelongsTo
   */
  public function product(): BelongsTo
  {
    return $this->belongsTo(
      Product::class
    );
  }

  /**
   * User product in cart
   *
   * @return BelongsTo
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(
      User::class
    );
  }

  /**
   * Skus product in cart
   *
   * @return BelongsTo
   */
  public function product_skus(): BelongsTo
  {
    return $this->belongsTo(
      ProductSkus::class,
      'product_sku_id',
      'id'
    );
  }

}
