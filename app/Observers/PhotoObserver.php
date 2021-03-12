<?php

namespace App\Observers;

use App\Models\Photo;
use App\Services\PhotoService;

class PhotoObserver
{
  /**
   * Handle the Photo "created" event.
   *
   * @param Photo $photo
   * @return void
   */
  public function created(Photo $photo): void
  {
    //
  }

  /**
   * Handle the Photo "updated" event.
   *
   * @param Photo $photo
   * @return void
   */
  public function updated(Photo $photo): void
  {
    //
  }

  /**
   * Handle the Photo "deleted" event.
   *
   * @param Photo $photo
   * @return void
   */
  public function deleted(Photo $photo): void
  {
    PhotoService::delete($photo->name, Photo::PHOTO_PATH, true);
    PhotoService::delete($photo->name, Photo::THUMBNAIL_PATH, true);
  }

  /**
   * Handle the Photo "restored" event.
   *
   * @param Photo $photo
   * @return void
   */
  public function restored(Photo $photo): void
  {
    //
  }

  /**
   * Handle the Photo "force deleted" event.
   *
   * @param Photo $photo
   * @return void
   */
  public function forceDeleted(Photo $photo): void
  {

  }
}
