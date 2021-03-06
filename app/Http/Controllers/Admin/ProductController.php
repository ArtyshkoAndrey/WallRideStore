<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Product;
use App\Models\ProductSkus;
use App\Services\PhotoService;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return Application|Factory|View|Response
   */
  public function index(Request $request): View
  {
    $name = $request->get('name');
    $type = $request->get('type', 'isset');
    $products = Product::query()->orderByDesc('id');
    if ($type === 'all') {
      $products = $products->withTrashed();
    } else if ($type === 'deleted') {
      $products = $products->onlyTrashed();
    }
    if ($name) {
      $products = $products->whereTranslationLike('title', '%' . $name . '%');
    }
    $products = $products->paginate(10);
    $filter = [
      'name' => $name,
      'type' => $type
    ];
    $products->appends($filter);
    return view('admin.product.index', compact('products', 'filter'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|View
   * @throws BindingResolutionException
   */
  public function create()
  {
    return view('admin.product.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return RedirectResponse
   */
  public function store(Request $request): RedirectResponse
  {
    $request->validate([
      'ru.title' => 'required|string|max:255',
      'en.title' => 'required|string|max:255',
      'price' => 'required|integer|min:0',
      'weight' => 'required|min:0',
      'brand' => 'required|exists:brands,id',
      'category' => 'required|exists:categories,id',
      'meta_title' => 'required|string',
      'meta_description' => 'required|string',
      'ru.description' => 'required|string',
      'en.description' => 'required|string',
      'on_sale' => 'boolean',
      'on_top' => 'boolean',
      'on_new' => 'boolean',
      'photos' => 'array',
    ]);
    $data = $request->all();
    $data['meta'] = (object)[
      'title' => $data['meta_title'],
      'description' => $data['meta_description']
    ];
    $product = new Product($data);
    $product
      ->brand()
      ->associate($request->get('brand'));

    $product
      ->category()
      ->associate($request->get('category'));

    $product->save();

    if (is_array($request->get('skus', []))) {
      foreach ($request->get('skus', []) as $id => $stock) {
        $ps = new ProductSkus();
        $ps->stock = $stock;
        $ps->skus()->associate($id);
        $ps->product()->associate($product->id);
        $ps->save();
      }
    }

    foreach ($data['photos'] as $name) {
      Photo::whereName($name)->first()->product()->associate($product->id)->save();
    }

    return redirect()->route('admin.product.index')->with('success', ['Товар успешно создан']);
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   */
  public function show(int $id): void
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return Application|Factory|View
   * @throws BindingResolutionException
   */
  public function edit(int $id)
  {
    $product = Product::find($id);
    return view('admin.product.edit', compact('product'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param int $id
   * @return RedirectResponse
   * @throws Exception
   */
  public function update(Request $request, int $id): RedirectResponse
  {
    $request->validate([
      'ru.title' => 'required|string|max:255',
      'en.title' => 'required|string|max:255',
      'price' => 'required|integer|min:0',
      'weight' => 'required|min:0',
      'brand' => 'required|exists:brands,id',
      'category' => 'required|exists:categories,id',
      'meta_title' => 'required|string',
      'meta_description' => 'required|string',
      'ru.description' => 'required|string',
      'en.description' => 'required|string',
      'on_sale' => 'boolean',
      'on_top' => 'boolean',
      'on_new' => 'boolean',
    ]);
    $product = Product::find($id);
    $ids = [];

    if (is_array($request->get('skus', []))) {
      foreach ($request->get('skus', []) as $id => $stock) {
        array_push($ids, $id);
        $flag = false;
        foreach ($product->productSkuses as $productSkus) {
          if ($productSkus->skus_id === $id) {
            $flag = true;

            $productSkus->stock = $stock;
            $productSkus->save();
          }
        }
        if (!$flag) {
          $ps = new ProductSkus();
          $ps->stock = $stock;
          $ps->skus()->associate($id);
          $ps->product()->associate($product->id);
          $ps->save();
        }
      }
    }

    $idsPS = $product->productSkuses()->pluck('skus_id')->toArray();

    $ids = array_diff($idsPS, $ids);

    foreach ($ids as $id) {
      ProductSkus::whereSkusId($id)->whereProductId($product->id)->delete();
    }
    $data = $request->all();
    $data['meta'] = (object)[
      'title' => $data['meta_title'],
      'description' => $data['meta_description']
    ];
    $product->update($data);
    $product
      ->brand()
      ->associate($request->brand);

    $product
      ->category()
      ->associate($request->category);
    $product->save();


    return redirect()->back()->with('success', ['Товар успешно обновлён']);
  }

  /**
   * Удаление или востановление товара.
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function destroy(int $id): RedirectResponse
  {
    $product = Product::withTrashed()->find($id);
    if ($product->trashed()) {
      $product->restore();
      return redirect()->back()->with('success', ['Товар успешно востановлен']);
    }

    try {
      $product->delete();
      return redirect()->back()->with('success', ['Товар успешно удалён']);
    } catch (Exception $exception) {
      return redirect()->back()->withErrors($exception->getMessage());
    }
  }

  public function photo(Request $request, $id): string
  {

    $name = PhotoService::create($request->file('file'), Product::THUMBNAIL_PATH, true, 30, false, 500);
    PhotoService::create($request->file('file'), Product::PHOTO_PATH, true, 80, false, 1200);
    $photo = new Photo(['name' => $name]);
    $photo->product()->associate($id);
    $photo->save();
    return $name;
  }

  public function photoDelete(Request $request): JsonResponse
  {
    $request->validate([
      'name' => 'required|string'
    ]);
    try {
      Photo::where('name', explode('.', $request->name)[0])->first()->delete();
      return response()->json(['status' => 'success']);
    } catch (Exception $e) {
      return response()->json(['status' => 'error'], 500);
    }
  }

  public function photoStore(Request $request)
  {
    $name = PhotoService::create($request->file('file'), Product::THUMBNAIL_PATH, true, 30, false, 500);
    PhotoService::create($request->file('file'), Product::PHOTO_PATH, true, 80, false, 1200);
    try {
      $photo = new Photo(['name' => $name]);
      $photo->product()->associate(null);
      $photo->save();
    } catch (Exception $exception) {
      PhotoService::delete($name, Product::PHOTO_PATH, true);
      PhotoService::delete($name, Product::THUMBNAIL_PATH, true);
      return response()->json($exception->getMessage(), 500);
    }
    return $name;
  }
}
