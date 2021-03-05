<?php

namespace App\Observers;

use App\Models\Faqs;
use App\Services\PhotoService;

class FaqsObserver
{
  /**
   * Handle the Faqs "created" event.
   *
   * @param Faqs $faqs
   * @return void
   */
  public function created(Faqs $faqs)
  {
    //
  }

  /**
   * Handle the Faqs "updated" event.
   *
   * @param Faqs $faqs
   * @return void
   */
  public function updated(Faqs $faqs)
  {
    //
  }

  /**
   * Handle the Faqs "deleted" event.
   *
   * @param Faqs $faqs
   * @return void
   */
  public function deleted(Faqs $faqs)
  {
    PhotoService::delete($faqs->image, Faqs::PHOTO_PATH, true);
  }

  /**
   * Handle the Faqs "restored" event.
   *
   * @param Faqs $faqs
   * @return void
   */
  public function restored(Faqs $faqs)
  {
    //
  }

  /**
   * Handle the Faqs "force deleted" event.
   *
   * @param Faqs $faqs
   * @return void
   */
  public function forceDeleted(Faqs $faqs)
  {
    PhotoService::delete($faqs->image, Faqs::PHOTO_PATH, true);
  }
}
