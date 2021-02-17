<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\OrderItem
 *
 * @property int $id
 * @property int $product_id
 * @property int $order_id
 * @property int $skus_id
 * @property int $amount
 * @property string $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Order $order
 * @property-read Product $product
 * @property-read Skus $skus
 * @method static Builder|OrderItem newModelQuery()
 * @method static Builder|OrderItem newQuery()
 * @method static Builder|OrderItem query()
 * @method static Builder|OrderItem whereAmount($value)
 * @method static Builder|OrderItem whereCreatedAt($value)
 * @method static Builder|OrderItem whereId($value)
 * @method static Builder|OrderItem whereOrderId($value)
 * @method static Builder|OrderItem wherePrice($value)
 * @method static Builder|OrderItem whereProductId($value)
 * @method static Builder|OrderItem whereSkusId($value)
 * @method static Builder|OrderItem whereUpdatedAt($value)
 * @mixin Eloquent
 */
class OrderItem extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'amount',
    'price'
  ];

  /**
   * @return BelongsTo
   */
  public function product(): BelongsTo
  {
    return $this->belongsTo(
      Product::class
    )
      ->withTrashed();
  }

  /**
   * @return BelongsTo
   */
  public function order(): BelongsTo
  {
    return $this->belongsTo(
      Order::class
    );
  }

  /**
   * @return BelongsTo
   */
  public function skus(): BelongsTo
  {
    return $this->belongsTo(
      Skus::class
    );
  }
}
