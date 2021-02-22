<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\ProductTranslation;
use Cache;
use Psr\SimpleCache\InvalidArgumentException;

class ProductTranslationObserver
{
  private array $categories;

  public function __construct()
  {
    $this->categories = Cache::remember('all-categories-id', config('app.cache.db'), function () {
      return Category::all()->pluck('id')->toArray();
    });
  }

  /**
   * Handle the ProductTranslation "created" event.
   *
   * @param ProductTranslation $product
   * @return void
   * @throws InvalidArgumentException
   */
  public function created(ProductTranslation $product): void
  {
    foreach ($this->categories as $category) {
      Cache::delete('similar-product-' . $category);
    }
  }

  /**
   * Handle the ProductTranslation "updated" event.
   *
   * @param ProductTranslation $product
   * @return void
   * @throws InvalidArgumentException
   */
  public function updated(ProductTranslation $product): void
  {
    foreach ($this->categories as $category) {
      Cache::delete('similar-product-' . $category);
    }
  }

  /**
   * Handle the ProductTranslation "deleted" event.
   *
   * @param ProductTranslation $product
   * @return void
   * @throws InvalidArgumentException
   */
  public function deleted(ProductTranslation $product): void
  {
    foreach ($this->categories as $category) {
      Cache::delete('similar-product-' . $category);
    }
  }

  /**
   * Handle the ProductTranslation "restored" event.
   *
   * @param ProductTranslation $product
   * @return void
   */
  public function restored(ProductTranslation $product): void
  {

  }

  /**
   * Handle the ProductTranslation "force deleted" event.
   *
   * @param ProductTranslation $product
   * @return void
   * @throws InvalidArgumentException
   */
  public function forceDeleted(ProductTranslation $product): void
  {
    foreach ($this->categories as $category) {
      Cache::delete('similar-product-' . $category);
    }
  }
}
