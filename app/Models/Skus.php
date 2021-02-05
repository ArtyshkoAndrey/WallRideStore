<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skus extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'weight',
  ];

  public function category (): BelongsTo
  {
    return $this->belongsTo(SkusCategory::class, 'skus_category_id', 'id', 'skus_categories');
  }

  public function products (): BelongsToMany
  {
    return $this->belongsToMany(Product::class, 'product_skuses', 'skus_id', 'product_id', 'id');
  }

}
