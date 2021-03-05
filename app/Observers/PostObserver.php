<?php

namespace App\Observers;

use App\Models\Post;
use App\Services\PhotoService;

class PostObserver
{
  /**
   * Handle the Post "created" event.
   *
   * @param Post $post
   * @return void
   */
  public function created(Post $post)
  {
    //
  }

  /**
   * Handle the Post "updated" event.
   *
   * @param Post $post
   * @return void
   */
  public function updated(Post $post)
  {
    //
  }

  /**
   * Handle the Post "deleted" event.
   *
   * @param Post $post
   * @return void
   */
  public function deleted(Post $post)
  {
    PhotoService::delete($post->photo, Post::PHOTO_PATH, true);
  }

  /**
   * Handle the Post "restored" event.
   *
   * @param Post $post
   * @return void
   */
  public function restored(Post $post)
  {
    //
  }

  /**
   * Handle the Post "force deleted" event.
   *
   * @param Post $post
   * @return void
   */
  public function forceDeleted(Post $post)
  {
    PhotoService::delete($post->photo, Post::PHOTO_PATH, true);
  }
}
