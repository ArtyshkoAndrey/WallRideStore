<?php

namespace App\Widget\Footer;


use App\Models\Category;
use App\Widget\Interfaces\ContractWidget;
use Cache;

class FooterCategoriesWidget implements ContractWidget {


  public function execute(){

    $categories = Cache::remember('categories-menu', config('app.cache.bd'), function () {
      return Category::withTranslation()->whereDoesntHave('parents')->with('child')->get();
    });

    return view('Widget::footer-categories', [
      'categories' => $categories
    ]);
  }

}
