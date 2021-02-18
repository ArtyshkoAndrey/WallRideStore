<?php

namespace App\Observers;

use App\Models\Brand;
use Illuminate\Support\Facades\File;

class BrandObserver
{
  /**
   * Handle the Photo "created" event.
   *
   * @param Brand $brand
   * @return void
   */
  public function created(Brand $brand)
  {
    //
  }

  /**
   * Handle the Photo "updated" event.
   *
   * @param Brand $brand
   * @return void
   */
  public function updated(Brand $brand)
  {
    //
  }

  /**
   * Handle the Photo "deleted" event.
   *
   * @param Brand $brand
   * @return void
   */
  public function deleted(Brand $brand)
  {
    $types = ['webp', 'jpg'];

    foreach ($types as $type) {
      if ($brand->photo)
        if (file_exists(public_path(Brand::PHOTO_PATH . $brand->photo . '.' . $type)))
          File::delete(public_path(Brand::PHOTO_PATH . $brand->photo . '.' . $type));

      if ($brand->logo)
        if (file_exists(public_path(Brand::LOGO_PATH . $brand->logo . '.' . $type)))
          File::delete(public_path(Brand::LOGO_PATH . $brand->logo . '.' . $type));
    }

  }

  /**
   * Handle the Photo "restored" event.
   *
   * @param Brand $brand
   * @return void
   */
  public function restored(Brand $brand)
  {
    //
  }

  /**
   * Handle the Photo "force deleted" event.
   *
   * @param Brand $brand
   * @return void
   */
  public function forceDeleted(Brand $brand)
  {

  }
}
