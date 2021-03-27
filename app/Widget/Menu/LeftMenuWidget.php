<?php

namespace App\Widget\Menu;

use App\Models\Brand;
use App\Models\Category;
use App\Widget\Interfaces\ContractWidget;
use Cache;

class LeftMenuWidget implements ContractWidget
{

  public function execute()
  {
    $brands = Cache::remember('brands-menu', config('app.cache.bd'), function () {
      return Brand::orderBy('name', 'ASC')->get();
    });

    $categories = Cache::remember('categories-menu', config('app.cache.bd'), function () {
      return Category::orderByTranslation('name')->withTranslation()->whereDoesntHave('parents')->with('child')->get();
    });

    return view('Widget::left-menu', [
      'brands' => $brands,
      'categories' => $categories
    ]);
  }

}
