<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Cache;


class HomeController extends Controller
{
  /**
   * @return View
   */
  public function index () :View
  {

//    $categories = Category::whereToMenu(true)->get();
    $newProducts = Product::whereOnNew(true)
      ->orderByDesc('id')
      ->take(8)
      ->get();
    $bestseller = Product::whereOnTop(true)
      ->orderByDesc('id')
      ->take(8)
      ->get();
//    return view('user.index', compact('categories', 'newProducts', 'hitProducts'));

    $brands = Cache::remember('brands-to-index', config('app.cache.bd'), function () {
      return Brand::where('to_index', true)->take(6)->get();
    });
    return view('user.index', compact('brands', 'bestseller', 'newProducts'));
  }

  /**
   * Смена языка сайта
   * @param string $locale
   * @return RedirectResponse
   */
  public function language (string $locale): RedirectResponse
  {
    setcookie('language', $locale, time() + (86400 * 30), "/");
    return redirect()->back();
  }
}
