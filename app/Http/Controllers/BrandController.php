<?php

namespace App\Http\Controllers;

use App\Exceptions\RedirectWithErrorsException;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Skus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Validator;

class BrandController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return void
   */
  public function index(): void
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return void
   */
  public function create(): void
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return void
   */
  public function store(Request $request): void
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return Application|Factory|View
   * @throws RedirectWithErrorsException
   */
  public function show(int $id, Request $request)
  {
    $brand = Brand::find($id);

    $items = Product::query();
    $order = $request->input('order', 'sort-new');
    $size = $request->get('size', []);

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
        if ($index === 0) {

          $items->whereHas('category', function ($query) use ($category) {
            $query->whereHas('parents', function ($query) use ($category) {
              $query->where('laravel_reserved_0.id', $category);
            })
              ->orWhere('categories.id', $category);
          });
        } else {
          $items = $items->orWhereHas('category', function ($query) use ($category, $index) {
            $query->whereHas('parents', function ($query) use ($category, $index) {
              $query->where('laravel_reserved_' . $index . '.id', $category);
            })
              ->orWhere('categories.id', $category);
          });
        }
      }
    }

    $items = $items->whereHas('brand', function ($query) use ($id) {
      return $query->where('brands.id', '=', $id);
    });

    if ($categoryArr !== []) {
      $attributes = Skus::whereHas('products.category', function ($q) use ($categoryArr) {
        $q->whereIn('products.category_id', $categoryArr);
      })->get();
    } else {
      $attributes = Skus::all();
    }

    if ($size) {
      if (!is_array($size))
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

    $items = $items->paginate(16);
    $filter = [
      'category' => $categoryArr,
      'order' => $order,
      'size' => $size
    ];

    return view('user.brand.index', compact('items', 'filter', 'attributes', 'brand'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return void
   */
  public function edit(int $id): void
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param int $id
   * @return void
   */
  public function update(Request $request, int $id): void
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return void
   */
  public function destroy(int $id): void
  {
    //
  }
}
