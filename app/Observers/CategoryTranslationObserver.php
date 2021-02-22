<?php

namespace App\Observers;

use App\Models\CategoryTranslation;
use Cache;
use Psr\SimpleCache\InvalidArgumentException;

class CategoryTranslationObserver
{
  /**
   * Handle the CategoryTranslation "created" event.
   *
   * @param CategoryTranslation $categoryTranslation
   * @return void
   * @throws InvalidArgumentException
   */
  public function created(CategoryTranslation $categoryTranslation): void
  {
    Cache::delete('categories-menu');
  }

  /**
   * Handle the CategoryTranslation "updated" event.
   *
   * @param CategoryTranslation $categoryTranslation
   * @return void
   * @throws InvalidArgumentException
   */
  public function updated(CategoryTranslation $categoryTranslation): void
  {
    Cache::delete('categories-menu');
  }

  /**
   * Handle the CategoryTranslation "deleted" event.
   *
   * @param CategoryTranslation $categoryTranslation
   * @return void
   * @throws InvalidArgumentException
   */
  public function deleted(CategoryTranslation $categoryTranslation): void
  {
    Cache::delete('categories-menu');
  }

  /**
   * Handle the CategoryTranslation "restored" event.
   *
   * @param CategoryTranslation $categoryTranslation
   * @return void
   */
  public function restored(CategoryTranslation $categoryTranslation): void
  {

  }

  /**
   * Handle the CategoryTranslation "force deleted" event.
   *
   * @param CategoryTranslation $categoryTranslation
   * @return void
   */
  public function forceDeleted(CategoryTranslation $categoryTranslation): void
  {

  }
}
