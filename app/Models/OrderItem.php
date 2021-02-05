<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

  public function product(): belongsTo
  {
    return $this->belongsTo(Product::class)->withTrashed();
  }

  public function order(): BelongsTo
  {
    return $this->belongsTo(Order::class);
  }

  public function skus(): BelongsTo
  {
    return $this->belongsTo(Skus::class);
  }
}
