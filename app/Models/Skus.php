<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Skus
 *
 * @property int $id
 * @property string $title
 * @property int $weight
 * @property int $skuscategory_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Skuscategory $category
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static Builder|Skus newModelQuery()
 * @method static Builder|Skus newQuery()
 * @method static Builder|Skus query()
 * @method static Builder|Skus whereCreatedAt($value)
 * @method static Builder|Skus whereId($value)
 * @method static Builder|Skus whereSkuscategoryId($value)
 * @method static Builder|Skus whereTitle($value)
 * @method static Builder|Skus whereUpdatedAt($value)
 * @method static Builder|Skus whereWeight($value)
 * @mixin Eloquent
 * @property-read Collection|ProductSkus[] $productSkus
 * @property-read int|null $product_skus_count
 */
class Skus extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'weight',
  ];

  public function category(): BelongsTo
  {
    return $this->belongsTo(Skuscategory::class, 'skuscategory_id', 'id', 'skuscategories');
  }

  public function products(): BelongsToMany
  {
    return $this->belongsToMany(Product::class, 'product_skuses', 'skus_id', 'product_id', 'id');
  }

  public function productSkus(): BelongsToMany
  {
    return $this->belongsToMany(ProductSkus::class);
  }

}
