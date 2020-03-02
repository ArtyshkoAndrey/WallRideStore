<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ProductsController extends Controller {

  public function search () {
    $name = Input::get('name', '');
    $products = Product::with('skus')->where('title','LIKE','%'.$name.'%')->paginate(16);
    $products->appends(['name' => $name]);
    return view('products.search', compact('products', 'name'));
  }

  public function all (Request $request) {
    if ($order = $request->input('order', '')) {
      if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
        if (in_array($m[1], ['price', 'sold_count', 'rating'])) {
          if ($m[1] == 'price') {
            $products = Product::select('products.*', \DB::raw("MAX(product_skus.price) AS max_price"), \DB::raw("MIN(product_skus.price) AS min_price"))
              ->join('product_skus', 'products.id', '=', 'product_skus.product_id')
              ->groupBy('products.id')
              ->orderBy($m[2] == 'desc' ? 'max_price' : 'min_price', $m[2])
              ->with('skus')->orderBy('price', $m[2] == 'asc'? 'desc' : 'asc')
              ->paginate(16);
          } else {
            $products = Product::with('skus')->orderBy($m[1], $m[2])->paginate(16);
          }
        }
      }
    } else {
      $products = Product::with('skus')->paginate(16);
    }
    $filters = [
      'order'  => $order,
    ];
    return view('products.all', compact('products', 'filters'));
  }
  public function index() {

    $productsNew = Product::where('on_new', true)->take(5)->with('skus')->get();
    $products = Product::take(5)->with('skus')->get();
    return view('products.index', [
      'productsNew' => $productsNew,
      'products' => $products
    ]);
  }

    public function show(Product $product, Request $request) {
      if (!$product->on_sale) {
          throw new InvalidRequestException('Нет в продаже');
      }

      $favored = false;
      if($user = $request->user()) {
          $favored = (bool) $user->favoriteProducts()->find($product->id);
      }

      $reviews = OrderItem::query()
          ->with(['order.user', 'productSku']) // 预先加载关联关系
          ->where('product_id', $product->id)
          ->whereNotNull('reviewed_at') // 筛选出已评价的
          ->orderBy('reviewed_at', 'desc') // 按评价时间倒序
          ->limit(10) // 取出 10 条
          ->get();
      $products = Product::take(4)->with('skus')->get();
      return view('products.show', [
        'product' => $product,
        'products' => $products,
        'favored' => $favored,
        'reviews' => $reviews
      ]);
    }

    public function favor(Product $product, Request $request)
    {
        $user = $request->user();
        if ($user->favoriteProducts()->find($product->id)) {
            return [];
        }

        $user->favoriteProducts()->attach($product);

        return [];
    }

    public function disfavor(Product $product, Request $request)
    {
        $user = $request->user();
        $user->favoriteProducts()->detach($product);

        return [];
    }

    public function favorites(Request $request)
    {
        $products = $request->user()->favoriteProducts()->paginate(16);
        return $products;
//        TODO  Сверстать страницу избранных
        return view('products.favorites', ['products' => $products]);
    }
}
