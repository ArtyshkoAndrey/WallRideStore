<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller {

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
//        $builder = Product::query()->where('on_sale', true);
//        if ($search = $request->input('search', '')) {
//            $like = '%'.$search.'%';
//            // 模糊搜索商品标题、商品详情、SKU 标题、SKU描述
//            $builder->where(function ($query) use ($like) {
//                $query->where('title', 'like', $like)
//                    ->orWhere('description', 'like', $like)
//                    ->orWhereHas('skus', function ($query) use ($like) {
//                        $query->where('title', 'like', $like)
//                            ->orWhere('description', 'like', $like);
//                    });
//            });
//        }
//
//        // 是否有提交 order 参数，如果有就赋值给 $order 变量
//        // order 参数用来控制商品的排序规则
//        if ($order = $request->input('order', '')) {
//            // 是否是以 _asc 或者 _desc 结尾
//            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
//                // 如果字符串的开头是这 3 个字符串之一，说明是一个合法的排序值
//                if (in_array($m[1], ['price', 'sold_count', 'rating'])) {
//                    // 根据传入的排序值来构造排序参数
//                    $builder->orderBy($m[1], $m[2]);
//                }
//            }
//        }
//
//        $products = $builder->paginate(16);
    $productsNew = Product::where('on_new', true)->take(10)->with('skus')->get();
    $products = Product::take(10)->with('skus')->get();
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
          $favored = boolval($user->favoriteProducts()->find($product->id));
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

        return view('products.favorites', ['products' => $products]);
    }
}
