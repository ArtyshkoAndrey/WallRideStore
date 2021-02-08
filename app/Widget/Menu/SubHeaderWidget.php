<?php

namespace App\Widget\Menu;

use App\Models\Brand;
use Cache;

class SubHeaderWidget
{
  public function execute(){
    $brands = Cache::remember('brands-left-menu', config('app.cache.bd'), function () {
      return Brand::withTranslation()->orderBy('name', 'ASC')->get();
    });

    return view('Widget::sub-header', [
      'brands' => $brands
    ]);
  }
}
