<?php

namespace App\Widget\Menu;

use App\Models\Brand;
use App\Models\Category;
use Cache;
use Illuminate\Contracts\Container\BindingResolutionException;

class SubHeaderWidget
{
  /**
   * @throws BindingResolutionException
   */
  public function execute()
  {
    $categories = Cache::remember('categories-menu-' . \App::getLocale(), config('app.cache.bd'), function () {
      return Category::orderByTranslation('name')->withTranslation()->whereDoesntHave('parents')->with('child')->get();
    });

    $brands = Cache::remember('brands-menu', config('app.cache.bd'), function () {
      return Brand::orderBy('name', 'ASC')->get();
    });

    $saleCategories = Cache::remember('sale-categories-' . \App::getLocale(), config('app.cache.db'), function () {
      return Category::whereHas('products', function($q) {
        $q->where('on_sale', true);
      })->withTranslation()->orderByTranslation('name')->get();
    });


    return view('Widget::sub-header', [
      'categories' => $categories,
      'brands' => $brands,
      'saleCategories' => $saleCategories
    ]);
  }
}
