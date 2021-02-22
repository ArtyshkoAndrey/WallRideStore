<?php

namespace App\Observers;

use App\Models\Brand;
use App\Services\PhotoService;
use Cache;
use Psr\SimpleCache\InvalidArgumentException;

class BrandObserver
{
  /**
   * Handle the Photo "created" event.
   *
   * @param Brand $brand
   * @return void
   * @throws InvalidArgumentException
   */
  public function created(Brand $brand): void
  {
    Cache::delete('brands-to-index');
    Cache::delete('brands-menu');
  }

  /**
   * Handle the Photo "updated" event.
   *
   * @param Brand $brand
   * @return void
   * @throws InvalidArgumentException
   */
  public function updated(Brand $brand): void
  {
    Cache::delete('brands-to-index');
    Cache::delete('brands-menu');
  }

  /**
   * Handle the Photo "deleted" event.
   *
   * @param Brand $brand
   * @return void
   * @throws InvalidArgumentException
   */
  public function deleted(Brand $brand): void
  {
    if ($brand->photo)
      PhotoService::delete($brand->photo, Brand::PHOTO_PATH, true);

    if ($brand->logo)
      PhotoService::delete($brand->photo, Brand::LOGO_PATH, true);

    Cache::delete('brands-to-index');
    Cache::delete('brands-menu');
  }

  /**
   * Handle the Photo "restored" event.
   *
   * @param Brand $brand
   * @return void
   */
  public function restored(Brand $brand): void
  {

  }

  /**
   * Handle the Photo "force deleted" event.
   *
   * @param Brand $brand
   * @return void
   */
  public function forceDeleted(Brand $brand): void
  {

  }
}
