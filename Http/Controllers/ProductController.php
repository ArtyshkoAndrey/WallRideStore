<?php

namespace App\Http\Controllers;

use App\Exceptions\RedirectWithErrorsException;
use App\Models\Product;
use App\Traits\FilterProductTrait;
use Cache;
use Error;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use JsonException;

class ProductController extends Controller
{
  use FilterProductTrait;

  /**
   * Search page
   *
   * @param Request $request
   * @return View
   * @throws RedirectWithErrorsException
   */
  public function search(Request $request): View
  {
    $q = $request->get('q');
    if ($q) {
      $products = Product::whereTranslationLike('title', '%' . $q . '%')->get();
      return view('user.product.search', compact('products'));
    }

    throw new RedirectWithErrorsException(__('errors_redirect.product.product_search'), 403);
  }


  /**
   * Displaying products by filter
   *
   * @param Request $request
   * @return Application|Factory|View
   * @throws RedirectWithErrorsException
   */
  public function all(Request $request): View
  {
    $order = $request->input('order', 'sort-new');
    $sale = $request->get('sale', false);
    $new = $request->get('new', false);
    $sizes = $request->get('size', []);
    $categories = $request->input('category', []);
    $categories_mobile = $request->input('category_mobile');
    $brands = $request->input('brand', []);

    if (!empty($request->input('size_mobile')) and $request->input('size_mobile') != 0) {
      $sizes = $request->input('size_mobile');
    }

    if (!is_array($sizes)) {
      $sizes = [$sizes];
    }
    if (!empty($request->input('brand_mobile')) and $request->input('brand_mobile') != 0) {
      $brands = $request->input('brand_mobile');
    }


    if (!is_array($brands)) {
      $brands = [$brands];
    }

    //dump($request->all());
    if (!empty($request->input('category_mobile'))) {
      $categories = $request->input('category_mobile');
    }
    if (!is_array($categories)) {
      $categories = [$categories];
    }


    $data = $this->filter($brands, $categories, $order, $sizes, 16, $sale, $new);
    $items = $data['items'];
    $filter = $data['filter'];
    $attributes = $data['attributes'];
    $itemsCount = $data['itemsCount'];
    $counter = $data['counter'];
    $brands = $data['brands'];

    foreach ($items as $i) {
      $Product = Product::with('productSkuses')->find($i->id);

      foreach ($Product->productSkuses as $productSkus) {
        $count[] = $productSkus->stock;
      }
      foreach ($i->skuses as $s) {

        $weights[] = $s->weight;
        $titles[] = $s->title;

      }
      array_multisort($weights, SORT_ASC, SORT_NUMERIC,
        $titles, SORT_ASC, SORT_REGULAR,
      );
      array_multisort($weights, SORT_ASC, SORT_NUMERIC,
        $count, SORT_ASC, SORT_REGULAR,
      );
      $skuses = array($weights, $titles, $count);


      $i->skusesnew = $skuses;
//      dump($i->skusesnew);
      $skuses = [];
      $weights = [];
      $titles = [];
      $count = [];

    }

    return view('user.product.catalog', compact('items', 'filter', 'itemsCount', 'attributes', 'counter', 'brands'));
  }

  /**
   * Product page
   *
   * @param int $id
   * @return View|void
   * @throws RedirectWithErrorsException
   */
  public function show(int $id): View
  {
    $product = Product::find($id);
    if ($product) {
      try {
        $childCategory = $product->category()->first();
        $categories = [];
        while ($category = $childCategory->parents()->first()) {
          array_unshift($categories, $category);
          $childCategory = $category;
        }
        array_push($categories, $product->category()->first());
      } catch (Error $exception) {
        $categories = [];
      }
      $similarProducts = [];
      if ($category = end($categories)) {
        $similarProducts = Cache::remember('similar-product-' . $category->id, config('app.cache.bd'), function () use ($category) {
          return $category->products()->take(4)->get();
        });

        $similarProducts = Product::with('productSkuses')->where('category_id', $category->id)->take(4)->get();
        foreach ($similarProducts as $i) {

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
      }


      return view('user.product.show', compact('product', 'categories', 'similarProducts'));
    }
    throw new RedirectWithErrorsException(__('errors_redirect.product.product_show'));
  }

  /**
   * Display Favor products
   *
   * @return Application|Factory|View
   * @throws JsonException
   */
  public function favor()
  {
    if (isset($_COOKIE['favor'])) {
      $ids = json_decode($_COOKIE['favor'], true, 512, JSON_THROW_ON_ERROR);
      $products = Product::findMany($ids);
    } else {
      $products = [];
    }
    return view('user.product.favor', compact('products'));
  }
}
