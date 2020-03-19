<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Product;
use App\Models\ProductSku;
use App\Models\Skus;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

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
          break;
        case 'all':
          $products = $products->withTrashed();
          break;
        case 'delete':
          $products = $products->onlyTrashed();
          break;
      }
    } else {
      $type = 'publish';
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
   * @return Factory|View
   */
  public function create()
  {
    return view('admin.products.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return RedirectResponse
   */
  public function store(Request $request)
  {
//    dd($request);
    $product = new Product();
    $product->title = $request->title;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->price_sale = isset($request->price_sale) ? $request->price_sale : null;
    $product->weight = $request->weight;
    $product->on_new = isset($request->on_new) ? 1 : 0;
    $product->on_sale = isset($request->on_sale) ? 1 : 0;
    $product->save();
    $product->categories()->sync($request->category);
    if (isset($request->stock)) {
      $sk = new ProductSku();
      $sk['stock'] = (int) $request->stock;
      $sk->product()->associate($product);
      $sk->save();
    } else if (isset($request->skus)) {
      foreach ($request->skus as $key => $skus) {
        if ($skus !== null && (int) $skus !== 0) {
          $sk = new ProductSku();
          $sk->stock = $skus;
          $sk->product()->associate($product);
          $sk->skus()->associate(Skus::find($key));
          $sk->save();
        }
      }
    }
    foreach ($request->photo as $key => $photo) {
      if ($photo !== null && $photo !== '') {
        $ph = Photo::where('name', $photo)->first();
        $ph->product()->associate($product);
        $ph->save();
      }
    }
    return redirect()->route('admin.production.products.index');
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
//    dd($request);
    $product = Product::withTrashed()->find($id);
    $product->title = $request->title;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->price_sale = $request->price_sale;
    $product->weight = $request->weight;
    $product->on_new = isset($request->on_new) ? 1 : 0;
    $product->on_sale = isset($request->on_sale) ? 1 : 0;
    $product->categories()->sync($request->category);
    if (isset($request->stock)) {
      if ($product->skus->count() === 1 && $product->skus->first()->skus_id === null) {
        $sk = ProductSku::where('product_id', $id)->first();
        $sk->stock = $request->stock;
        $sk->save();
      } else {
        ProductSku::where('product_id', $id)->delete();
        $sk = new ProductSku();
        $sk['stock'] = (int) $request->stock;
        $sk->product()->associate($product);
        $sk->save();
      }
    } else if (isset($request->skus)) {
      ProductSku::where('product_id', $id)->delete();
      foreach ($request->skus as $key => $skus) {
        if ($skus !== null && (int) $skus !== 0) {
          $sk = new ProductSku();
          $sk->stock = $skus;
          $sk->product()->associate($product);
          $sk->skus()->associate(Skus::find($key));
          $sk->save();
        }
      }
    }

    $product->save();
    return redirect()->route('admin.production.products.edit', $id);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return RedirectResponse
   */
  public function destroy($id) {
    $pr = Product::withTrashed()->find($id);
    if ($pr->trashed()) {
      $pr->forceDelete();
    } else {
      $pr->delete();
    }
    return redirect()->back();
  }

  public function collectionsDestroy(Request $request) {
    Product::destroy($request->id);
    return ['status' => 'success'];
  }

  public function collectionsRestore(Request $request) {
    foreach($request['data']['id'] as $id) {
      Product::withTrashed()->find($id)->restore();
    }
    return ['status' => 'success'];
  }

  public function photo(Request $request, $id) {
    // read image from temporary file
    $image = $request->file('file');
    $destinationPath = public_path('storage/products/');
    $name = $request->file('file')->getClientOriginalName();
    $img = Image::make($image->getRealPath());
    $img->save($destinationPath.'/'.$name);
    $ph = new Photo();
    $ph['name'] = $name;
    $pr = Product::withTrashed()->find($id);
    $ph->product()->associate($pr);
    $ph->save();
    echo $name;
  }
  public function photoDelete(Request $request, $id) {
    // read image from temporary file
    echo $request->name;
    File::delete(public_path('storage/products/') . '/' .$request->name);
    $ph = Photo::where('name', $request->name)->first();
    $ph->delete();
//    $product->photo->
  }

  public function photoCreate(Request $request) {
    // read image from temporary file
    $image = $request->file('file');
    $destinationPath = public_path('storage/products/');
    $name = $request->file('file')->getClientOriginalName();
    $img = Image::make($image->getRealPath());
    $img->save($destinationPath.'/'.$name);
    $ph = new Photo();
    $ph['name'] = $name;
    $ph->save();
    echo $name;
  }

  public function photoDeleteCreate(Request $request) {
    // read image from temporary file
    echo $request->name;
    File::delete(public_path('storage/products/') . '/' .$request->name);
    $ph = Photo::where('name', $request->name)->first();
    $ph->delete();
  }
}
