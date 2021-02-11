<?php

namespace App\Widget\Menu;

use App\Models\Brand;
use App\Models\Category;
use Cache;

class SubHeaderWidget
{
  public function execute(){
    $categories = Cache::remember('categories-menu', config('app.cache.bd'), function () {
      return Category::withTranslation()->whereDoesntHave('parents')->with('child')->get();
    });

    $brands = Cache::remember('brands-menu', config('app.cache.bd'), function () {
      return Brand::withTranslation()->orderBy('name', 'ASC')->get();
    });


    return view('Widget::sub-header', [
      'categories' => $categories,
      'brands' => $brands
    ]);
  }
}
