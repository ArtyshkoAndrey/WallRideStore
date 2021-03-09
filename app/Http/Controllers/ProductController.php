<?php

namespace App\Http\Controllers;

use App\Exceptions\RedirectWithErrorsException;
use App\Models\Product;
use App\Models\Skus;
use Cache;
use Error;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Validator;

class ProductController extends Controller
{

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
    } else {
      throw new RedirectWithErrorsException(__('errors_redirect.product.product_search'), 403);
    }
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
    $items = Product::query();
    $order = $request->input('order', 'sort-new');
    $sale = $request->get('sale', false);
    $new = $request->get('new', false);
    $size = $request->get('size', []);

    if ($sale) {
      $items = $items->whereOnSale(true);
    }

    if ($new) {
      $items = $items->whereOnNew(true);
    }

    if ($order) {
      if ($order === 'sort-new') {
        $items = $items->orderBy('created_at', 'desc');
      } else if ($order === 'sort-old') {
        $items = $items->orderBy('created_at');
      } else if ($order === 'sort-expensive') {
        $items = $items->orderBy('price', 'desc');
      } else if ($order === 'sort-cheap') {
        $items = $items->orderBy('price');
      }
    }

    if ($sex = $request->input('sex', [])) {
      if (!is_array($sex))
        $sex = [$sex];

      $items = $items->whereIn('sex', $sex);
    }

    if ($categoryArr = $request->input('category', [])) {
      if (!is_array($categoryArr))
        $categoryArr = [$categoryArr];

      $rules = [
        'categories' => 'required|array',
        'categories.*' => 'exists:categories,id', // check each item in the array
      ];
      $validator = Validator::make(['categories' => $categoryArr], $rules);
      if ($validator->fails()) {
        throw new RedirectWithErrorsException(__('errors_redirect.product.product_catalog_categories'));
      }
      foreach ($categoryArr as $index => $category) {
        if ($index == 0) {
          $items = $items->whereHas('category', function ($query) use ($category) {
            return $query->where('categories.id', '=', $category);
          });
        } else {
          $items = $items->orWhereHas('category', function ($query) use ($category) {
            return $query->where('categories.id', '=', $category);
          });
        }
      }
    }

    if ($brandArr = $request->input('brand', [])) {
      if (!is_array($brandArr))
        $brandArr = [$brandArr];

      $rules = [
        'brands' => 'required|array',
        'brands.*' => 'exists:brands,id', // check each item in the array
      ];
      $validator = Validator::make(['brands' => $brandArr], $rules);
      if ($validator->fails()) {
        throw new RedirectWithErrorsException(__('errors_redirect.product.product_catalog_brands'));
      }

      foreach ($brandArr as $index => $brand) {
        if ($index == 0) {
          $items = $items->whereHas('brand', function ($query) use ($brand) {
            return $query->where('brands.id', '=', $brand);
          });
        } else {
          $items = $items->orWhereHas('brand', function ($query) use ($brand) {
            return $query->where('brands.id', '=', $brand);
          });
        }
      }
    }

    if ($brandArr !== [] && $categoryArr !== []) {
      $attributes = Skus::whereHas('products.brand', function ($q) use ($brandArr) {
        $q->whereIn('products.brand_id', $brandArr);
      })
        ->whereHas('products.category', function ($q) use ($categoryArr) {
          $q->whereIn('products.category_id', $categoryArr);
        })->get();
    } else if ($categoryArr !== [] && $brandArr === []) {
      $attributes = Skus::whereHas('products.category', function ($q) use ($categoryArr) {
        $q->whereIn('products.category_id', $categoryArr);
      })->get();
    } else if ($categoryArr === [] && $brandArr !== []) {
      $attributes = Skus::whereHas('products.brand', function ($q) use ($brandArr) {
        $q->whereIn('products.brand_id', $brandArr);
      })->get();
    } else {
      $attributes = Skus::all();
    }

    if ($size) {
      if (is_array($size))
        $size = [$size];

      $rules = [
        'skuses' => 'required|array',
        'skuses.*' => 'exists:skuses,id', // check each item in the array
      ];
      $validator = Validator::make(['skuses' => $size], $rules);
      if ($validator->fails()) {
        throw new RedirectWithErrorsException(__('errors_redirect.product.product_catalog_skuses'));
      }

      $items = $items->whereHas('skuses', function ($query) use ($size) {
        return $query->whereIn('skus_id', $size);
      });
    }

    $itemsCount = $items->count();
    $items = $items->paginate(16);
    $filter = [
      'category' => $categoryArr,
      'order' => $order,
      'brand' => $brandArr,
      'sale' => $sale,
      'new' => $new,
      'sex' => $sex,
      'size' => $size
    ];
    $counter = 0;
    foreach ($filter as $name => $f) {
      if ($name !== 'sale' && $name !== 'new' && $name !== 'order')
        $counter += count($f);
      else
        if ($f && $name !== 'order')
          $counter++;
    }
    return view('user.product.catalog', compact('items', 'filter', 'itemsCount', 'attributes', 'counter'));
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
      }
      return view('user.product.show', compact('product', 'categories', 'similarProducts'));
    }
    throw new RedirectWithErrorsException(__('errors_redirect.product.product_show'));
  }
}
