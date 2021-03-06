<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Services\PhotoService;
use Cache;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psr\SimpleCache\InvalidArgumentException;

class BrandController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return Application|Factory|View
   */
  public function index(Request $request)
  {
    $brands = Brand::query();
    $name = $request->get('name');
    if ($name) {
      $brands = $brands->where('name', 'like', '%' . $name . '%');
    }

    $filter = [
      'name' => $name
    ];
    $brands = $brands->paginate(7);
    $brands->appends($filter);
    return view('admin.brand.index', compact('brands', 'filter'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return void
   */
  public function create(): void
  {

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
      'name'            => 'required|string|unique:brands,name',
      'photo'           => 'sometimes|image',
      'logo'            => 'sometimes|image',
      'ru.description'  => 'required|string',
      'en.description'  => 'required|string',
      'to_index'        => 'required|boolean'
    ]);

    $data = $request->all();
    if ($request->has('photo')) {
      $data['photo'] = PhotoService::create($request->file('photo'), Brand::PHOTO_PATH, true, 30, true, 500);
    }
    if ($request->has('logo')) {
      $data['logo'] = PhotoService::create($request->file('logo'), Brand::LOGO_PATH, true, 30, true, 500);
    }

    Brand::create($data);
    return redirect()->back()->with('success', ['Бренд успешно создан']);
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   * @return void
   */
  public function show(int $id): void
  {

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   * @return void
   */
  public function edit(int $id): void
  {

  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param int $id
   * @return RedirectResponse
   */
  public function update(Request $request, int $id): RedirectResponse
  {
    $request->validate([
      'name'            => 'required|string|unique:brands,name,' . $id,
      'photo'           => 'sometimes|image',
      'logo'            => 'sometimes|image',
      'ru.description'  => 'required|string',
      'en.description'  => 'required|string',
      'to_index'        => 'required|boolean'
    ]);

    $brand = Brand::find($id);

    $data = $request->all();
    if ($request->has('photo')) {
      $data['photo'] = PhotoService::create($request->file('photo'), Brand::PHOTO_PATH, true, 30, true, 500);
    }

    if ($request->has('logo')) {
      $data['logo'] = PhotoService::create($request->file('logo'), Brand::LOGO_PATH, true, 30, true, 500);
    }

    $brand->update($data);

    return redirect()->back()->with('success', ['Бренд успешно обнавлён']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return RedirectResponse
   * @throws Exception
   */
  public function destroy(int $id): RedirectResponse
  {
    $brand = Brand::find($id);
    $brand->delete();
    return redirect()->back()->with('success', ['Бренд успешно удалён']);
  }
}
