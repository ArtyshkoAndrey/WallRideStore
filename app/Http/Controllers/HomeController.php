<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Slider;
use Cache;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
  /**
   * Homepage
   *
   * @return View
   * @throws \Psr\SimpleCache\InvalidArgumentException
   */
  public function index(): View
  {
    $newProducts = Product::whereOnNew(true)
      ->orderByDesc('id')
      ->with('productSkuses')
      ->take(8)
      ->get();

    $bestseller = Product::whereOnTop(true)
      ->orderByDesc('id')
      ->with('productSkuses')
      ->take(8)
      ->get();
    Cache::delete('sliders-index-page');
    $sliders = Cache::remember('sliders-index-page', config('app.cache.db'), function () {
      return Slider::all();
    });

    $brands = Cache::remember('brands-to-index', config('app.cache.bd'), function () {
      return Brand::where('to_index', true)->take(6)->get();
    });
    foreach ($newProducts as $i) {

      foreach ($i->skuses as $s) {

        $weights[] = $s->weight;
        $titles[] = $s->title;

      }
      array_multisort($weights, SORT_ASC, SORT_NUMERIC,
        $titles
      );
      foreach ($i->productSkuses as $productSkus) {
        $count[] = $productSkus->stock;
      }

      $skuses = array($weights, $titles, $count);
      $i->skusesnew = $skuses;
      //   dump($i);
      //    dump($i->skusesnew);
      $skuses = [];
      $weights = [];
      $titles = [];
      $count = [];
    }

    foreach ($bestseller as $i) {

      foreach ($i->skuses as $s) {

        $weights[] = $s->weight;
        $titles[] = $s->title;

      }
      array_multisort($weights, SORT_ASC, SORT_NUMERIC,
        $titles
      );
      foreach ($i->productSkuses as $productSkus) {
        $count[] = $productSkus->stock;
      }

      $skuses = array($weights, $titles, $count);
      $i->skusesnew = $skuses;
      //   dump($i);
      //    dump($i->skusesnew);
      $skuses = [];
      $weights = [];
      $titles = [];
      $count = [];
    }

    return view('user.index', compact('brands', 'bestseller', 'newProducts', 'sliders'));
  }

  /**
   * Change site language
   *
   * @param string $locale
   * @return RedirectResponse
   */
  public function language(string $locale): RedirectResponse
  {
    setcookie('language', $locale, time() + (86400 * 30), "/");
    return redirect()->back();
  }

  public function delievery() {
    return view('user.delievery.delievery');
  }
  /**
   * Page PRIVACY POLICY
   *
   * @return View
   */
  public function policy(): View
  {
    return view('user.page.policy');
  }

  /**
   * Page PAY
   *
   * @return View
   */
  public function pay(): View
  {
    return view('user.page.pay');
  }
}
