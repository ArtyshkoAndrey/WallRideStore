<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Skus
 *
 * @property int $id
 * @property string $title
 * @property int $weight
 * @property int $skuscategory_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Skuscategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Skus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skus query()
 * @method static \Illuminate\Database\Eloquent\Builder|Skus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skus whereSkuscategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skus whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skus whereWeight($value)
 * @mixin \Eloquent
 */
class Skus extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'weight',
  ];

  public function category (): BelongsTo
  {
    return $this->belongsTo(Skuscategory::class, 'skuscategory_id', 'id', 'skuscategories');
  }

  public function products (): BelongsToMany
  {
    return $this->belongsToMany(Product::class, 'product_skuses', 'skus_id', 'product_id', 'id');
  }

  public function productSkus (): BelongsToMany
  {
    return $this->belongsToMany(ProductSkus::class);
  }

}
