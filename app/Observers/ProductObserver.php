<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\Product;
use Cache;
use Exception;
use Psr\SimpleCache\InvalidArgumentException;

class ProductObserver
{

  private array $categories;

  public function __construct()
  {
    $this->categories = Cache::remember('all-categories-id', config('app.cache.db'), function () {
      return Category::all()->pluck('id')->toArray();
    });
  }

  /**
   * Handle the Product "created" event.
   *
   * @param Product $product
   * @return void
   * @throws InvalidArgumentException
   */
  public function created(Product $product): void
  {
    foreach ($this->categories as $category) {
      Cache::delete('similar-product-' . $category);
    }
  }

  /**
   * Handle the Product "updated" event.
   *
   * @param Product $product
   * @return void
   * @throws InvalidArgumentException
   */
  public function updated(Product $product): void
  {
    foreach ($this->categories as $category) {
      Cache::delete('similar-product-' . $category);
    }
  }

  /**
   * Handle the Product "deleted" event.
   *
   * @param Product $product
   * @return void
   * @throws InvalidArgumentException
   */
  public function deleted(Product $product): void
  {
    foreach ($this->categories as $category) {
      Cache::delete('similar-product-' . $category);
    }
  }

  /**
   * Handle the Product "restored" event.
   *
   * @param Product $product
   * @return void
   */
  public function restored(Product $product): void
  {

  }

  /**
   * Handle the Product "force deleted" event.
   *
   * @param Product $product
   * @return void
   * @throws Exception
   * @throws InvalidArgumentException
   */
  public function forceDeleted(Product $product): void
  {
    foreach ($this->categories as $category) {
      Cache::delete('similar-product-' . $category);
    }
  }
}
