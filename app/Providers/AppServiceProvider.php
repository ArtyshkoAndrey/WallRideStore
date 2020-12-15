<?php

namespace App\Providers;

use App\Jobs\ProcessOrderMailer;
use App\Models\Order;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Config::set("services.google.redirect", url(Config::get('services')['google']['redirect']));
      Config::set("services.vkontakte.redirect", url(Config::get('services')['vkontakte']['redirect']));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->register(TelescopeServiceProvider::class);
    }
}
