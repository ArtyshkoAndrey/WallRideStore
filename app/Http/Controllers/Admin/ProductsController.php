<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductsController extends Controller {
  public function __construct() {

  }

  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return Factory|View
   */
  public function index(Request $request)
  {
    $type = $request->type;
    $search = $request->search;
    $products = Product::query();

    if (isset($search)) {

      if ($type === 'delete') {
        $products = $products->onlyTrashed()->orWhere('title', 'LIKE', '%'.$search.'%')
          ->onlyTrashed()->orWhere('created_at', 'LIKE', '%'.$search.'%')
          ->onlyTrashed()->orWhere('price', 'LIKE', '%'.$search.'%');
      } else {
        $products = $products->orWhere('title', 'LIKE', '%'.$search.'%')
          ->orWhere('created_at', 'LIKE', '%'.$search.'%')
          ->orWhere('price', 'LIKE', '%'.$search.'%');
      }
    } else {
      $search = '';
    }

    if (isset($type)) {
      switch ($type) {
        case 'publish':
          $products = $products;
          break;
        case 'all':
          $products = $products->withTrashed();
          break;
        case 'delete':
          $products = $products->onlyTrashed();
          break;
      }
    } else {
      $type = 'all';
      $products = $products->withTrashed();
    }

    $products = $products->orderByDesc('created_at');
    $products = $products->paginate(5);
    $filters = [
      'type'  => $type,
      'search'=> $search
    ];

    return view('admin.products.index', compact('products', 'filters'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Factory|View
   */
  public function edit($id)
  {
    $product = Product::withTrashed()->find($id);
    return view('admin.products.edit', compact('product'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param  int  $id
   * @return RedirectResponse
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'created_at' => 'required|date',
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return RedirectResponse
   */
  public function destroy($id) {

  }
}
