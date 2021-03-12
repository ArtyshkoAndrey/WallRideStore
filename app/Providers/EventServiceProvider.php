<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Faqs;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\User;
use App\Observers\BrandObserver;
use App\Observers\CategoryObserver;
use App\Observers\CategoryTranslationObserver;
use App\Observers\FaqsObserver;
use App\Observers\PhotoObserver;
use App\Observers\PostObserver;
use App\Observers\ProductObserver;
use App\Observers\ProductTranslationObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
  /**
   * The event listener mappings for the application.
   *
   * @var array
   */
  protected $listen = [
    Registered::class => [
      SendEmailVerificationNotification::class,
    ],
  ];

  /**
   * Register any events for your application.
   *
   * @return void
   */
  public function boot()
  {
    Photo::observe(PhotoObserver::class);
    User::observe(UserObserver::class);
    Product::observe(ProductObserver::class);
    ProductTranslation::observe(ProductTranslationObserver::class);
    Category::observe(CategoryObserver::class);
    CategoryTranslation::observe(CategoryTranslationObserver::class);
    Brand::observe(BrandObserver::class);
    Post::observe(PostObserver::class);
    Faqs::observe(FaqsObserver::class);
  }
}
