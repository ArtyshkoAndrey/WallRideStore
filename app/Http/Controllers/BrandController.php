<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Traits\FilterProductTrait;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BrandController extends Controller
{

  use FilterProductTrait;

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
   * @param Request $request
   * @return Application|Factory|View
   * @throws BindingResolutionException
   * @throws \App\Exceptions\RedirectWithErrorsException
   */
  public function show(int $id, Request $request)
  {
    $brand = Brand::find($id);
    $order = $request->input('order', 'sort-new');
    $sizes = $request->get('size', []);
    $categories = $request->input('category', []);
    if (!is_array($sizes)) {
      $sizes = [$sizes];
    }
    $brands = [$brand->id];
    if (!is_array($categories)) {
      $categories = [$categories];
    }

    $data = $this->filter($brands, $categories, $order, $sizes, 16);
    $items = $data['items'];
    $filter = $data['filter'];
    $attributes = $data['attributes'];
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
