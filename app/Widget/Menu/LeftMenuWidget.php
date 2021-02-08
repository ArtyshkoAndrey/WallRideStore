<?php

namespace App\Widget\Menu;

use App\Models\Brand;
use App\Widget\Interfaces\ContractWidget;
use Cache;

class LeftMenuWidget implements ContractWidget {


  public function execute(){
    $brands = Cache::remember('brands-left-menu', config('app.cache.bd'), function () {
      return Brand::withTranslation()->orderBy('name', 'ASC')->get();
    });

    return view('Widget::left-menu', [
      'brands' => $brands
    ]);
  }

}
