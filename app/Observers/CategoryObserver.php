<?php

namespace App\Observers;

use App\Models\Category;
use App\Services\PhotoService;
use Cache;
use Psr\SimpleCache\InvalidArgumentException;

class CategoryObserver
{
  /**
   * Handle the Category "created" event.
   *
   * @param Category $category
   * @return void
   * @throws InvalidArgumentException
   */
  public function created(Category $category): void
  {
    Cache::delete('categories-menu-en');
    Cache::delete('categories-menu-ru');
    Cache::delete('all-categories-id');
  }

  /**
   * Handle the Category "updated" event.
   *
   * @param Category $category
   * @return void
   * @throws InvalidArgumentException
   */
  public function updated(Category $category): void
  {
    Cache::delete('categories-menu-en');
    Cache::delete('categories-menu-ru');
    Cache::delete('all-categories-id');
  }

  /**
   * Handle the Category "deleted" event.
   *
   * @param Category $category
   * @return void
   * @throws InvalidArgumentException
   */
  public function deleted(Category $category): void
  {
    if ($category->photo) {
      PhotoService::delete($category->photo, Category::PHOTO_PATH, false);
    }

    Cache::delete('categories-menu-en');
    Cache::delete('categories-menu-ru');
    Cache::delete('all-categories-id');
  }

  /**
   * Handle the Category "restored" event.
   *
   * @param Category $category
   * @return void
   */
  public function restored(Category $category): void
  {

  }

  /**
   * Handle the Category "force deleted" event.
   *
   * @param Category $category
   * @return void
   */
  public function forceDeleted(Category $category): void
  {

  }
}
