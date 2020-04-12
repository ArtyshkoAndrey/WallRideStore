<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Helpers\CollectionHelper;
use App\Models\Category;
use App\Models\Header;
use App\Models\News;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Skus;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ProductsController extends Controller {

  public function search (Request $request) {
    $name = Input::get('name', '');
    $prodCat = Product::with('skus', 'photos')->whereHas('categories', function($q) use($name) {
      $q->where('categories.name', 'like', '%'.$name.'%');
    })->get()->toArray();
    $related = new Collection();
    $products = Product::with('skus', 'photos')->where('title','LIKE','%'.$name.'%')->get()->toArray();
    $related = $related->merge($prodCat);
    $related = $related->merge($products);
    $products = CollectionHelper::paginate($related, count($related), 16); //Filter the page var
    $products->appends(['name' => $name]);
    return view('products.search', compact('products', 'name'));
  }

  public function all (Request $request)
  {
    $products = Product::query();
    if ($order = $request->input('order', null)) {
      if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
        if (in_array($m[1], ['price', 'sold_count', 'new'])) {
          if ($m[1] == 'price') {
            $products = $products->select('products.*', \DB::raw("MAX(price) AS max_price"), \DB::raw("MIN(price) AS min_price"))
              ->join('product_skus', 'products.id', '=', 'product_skus.product_id')
              ->groupBy('products.id')
              ->orderBy($m[2] == 'desc' ? 'max_price' : 'min_price', $m[2])
              ->with('skus', 'photos')->orderBy('price', $m[2] == 'asc' ? 'desc' : 'asc');
          } else if ($m[1] == 'new') {
            $products = $products->orderBy('created_at', 'desc')->with('skus', 'photos');
          } else {
            $products = $products->with('skus', 'photos')->orderBy($m[1], $m[2]);
          }
        }
      }
    }
    if ($brand = $request->input('brand', null)) {
      $products = $products->whereHas('brands', function ($query) use ($brand) {
        return $query->where('brands.id', $brand);
      });
    }
    if ($category = $request->input('category', null)) {
      $products = $products->whereHas('categories', function ($query) use ($category) {
        $query->whereHas('parents', function ($query) use ($category) {
          $query->where('laravel_reserved_0.id', $category);
        })
          ->orWhere('categories.id', $category);
      });
    }

    if ($size = $request->input('size', null)) {
      $products = $products->whereHas('skus.skus', function ($query) use ($size) {
        $query->where('skuses.id', $size);
      });
    }

    if($brand !== null) {
      $categories = Category::whereHas('products.brands', function ($q) use ($brand) {
        $q->where('products_brands.brand_id', $brand);
      })->get();
    } else {
      $categories = Category::all();
    }

    if ($brand !== null && $category !== null) {
      $attributes = Skus::whereHas('products.brands', function ($q) use ($brand) {
        $q->where('products_brands.brand_id', $brand);
      })
      ->whereHas('products.categories', function ($q) use ($category) {
        $q->where('products_categories.category_id', $category);
      })->get();
    } else if ($category !== null && $brand === null) {
      $attributes = Skus::whereHas('products.categories', function ($q) use ($category) {
        $q->where('products_categories.category_id', $category);
      })->get();
    } else if ($category === null && $brand !== null) {
      $attributes = Skus::whereHas('products.brands', function ($q) use ($brand) {
        $q->where('products_brands.brand_id', $brand);
      })->get();
    } else {
      $attributes = Skus::all();
    }
//    dd($attributes);
    $filters = [
      'order'     => $order,
      'brand'     => $brand,
      'category'  => $category,
      'size'      => $size
    ];
    $products = $products->with('skus', 'photos')->paginate(16);
//    dd($products);
    return view('products.all', compact('products', 'filters', 'attributes', 'categories'));
  }

  public function allsale ()
  {
    $products = Product::query();
    $products = $products->with('skus', 'photos')->where('on_sale', true)->paginate(16);
    return view('products.all_sale', compact('products'));
  }

  public function allfavor ()
  {
    $products = Auth::user()->favoriteProducts()->with('skus', 'photos')->paginate(16);
    return view('products.favor', compact('products'));
  }

  public function index() {
    $productsNew = Product::where('on_new', true)->orderBy('created_at', 'desc')->take(5)->with('skus', 'photos')->get();

    $category = Category::withCount('products')->orderBy('products_count', 'desc')->first();
    if($category) {
      $products = $category->products()->take(5)->with('skus', 'photos')->get();
    } else {
      $products = [];
      $category = null;
    }
    $news = News::take(3)->get();
    $h = Header::first();
    return view('products.index', [
      'productsNew' => $productsNew,
      'products' => $products,
      'news' => $news,
      'h' => $h,
      'category' => $category
    ]);
  }

  public function show(Product $product, Request $request) {
    if (isset($product->deleted_at)) {
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
    $ids = $product->categories->pluck('id')->toArray();
    $products = Product::with('photos', 'skus', 'categories')->whereHas('categories', function($query) use ($ids) {
      $query->whereIn('categories.id', $ids);
    })->take(4)->get();
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
