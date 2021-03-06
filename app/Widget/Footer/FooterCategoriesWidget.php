<?php

namespace App\Widget\Footer;


use App\Models\Category;
use App\Widget\Interfaces\ContractWidget;
use Cache;

class FooterCategoriesWidget implements ContractWidget
{


  public function execute()
  {

    $categories = Cache::remember('categories-menu-' . \App::getLocale(), config('app.cache.bd'), function () {
      return Category::orderByTranslation('name')->withTranslation()->whereDoesntHave('parents')->with('child')->get();
    });

    return view('Widget::footer-categories', [
      'categories' => $categories
    ]);
  }

}
