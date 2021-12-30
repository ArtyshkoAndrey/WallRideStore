<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\RedirectWithErrorsException;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Services\PhotoService;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SliderController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|View
   * @throws BindingResolutionException
   */
  public function index()
  {
    $sliders = Slider::paginate(15);

    return view('admin.slider.index', compact('sliders'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return View
   * @throws BindingResolutionException
   */
  public function create(): View
  {
    return view('admin.slider.create');
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
      'ru.h1' => 'required|string',
      'ru.h2' => 'required|string',
      'ru.btn_text' => 'required|string',
      'en.h1' => 'required|string',
      'en.h2' => 'required|string',
      'en.btn_text' => 'required|string',
      'url' => 'required|string',
      'photo' => 'required|string',
      'mobile_photo' => 'required|string'
    ]);

    $slider = Slider::create($request->all());
    $slider->save();

    return redirect()->route('admin.slider.index')->with('success', ['Слайдер успешно создан']);
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return void
   */
  public function show(int $id): void
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param Slider $slider
   * @return View
   * @throws BindingResolutionException
   */
  public function edit(Slider $slider): View
  {
    return view('admin.slider.edit', compact('slider'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param Slider $slider
   * @return RedirectResponse
   */
  public function update(Request $request, Slider $slider): RedirectResponse
  {
    $request->validate([
      'ru.h1' => 'required|string',
      'ru.h2' => 'required|string',
      'ru.btn_text' => 'required|string',
      'en.h1' => 'required|string',
      'en.h2' => 'required|string',
      'en.btn_text' => 'required|string',
      'url' => 'required|string',
      'photo' => 'required|string',
      'mobile_photo' => 'required|string'
    ]);

    $slider->update($request->all());
    $slider->save();

    return redirect()->route('admin.slider.index')->with('success', ['Слайдер успешно обновлён']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Slider $slider
   * @return RedirectResponse
   * @throws Exception
   */
  public function destroy(Slider $slider): RedirectResponse
  {
    try {
      $slider->delete();
      return redirect()->route('admin.slider.index')->with('success', ['Слайдер успешно обновлён']);
    } catch (Exception $e) {
      throw new RedirectWithErrorsException('Ошибка удаления');
    }
  }

  /**
   * Save file in storage onload dropzone
   *
   * @param Request $request
   * @return string
   */
  public function photo_store(Request $request): string
  {
    $request->validate([
      'file' => 'required|image',
      'type' => 'required|string'
    ]);

    $data = $request->all();
    if ($data['type'] !== 'mobile' && $data['type'] !== 'desktop') {
      $data['type'] = 'desktop';
    }
    if ($data['type'] === 'desktop') {
      $storage = Slider::PHOTO_PATH;
    } else {
      $storage = Slider::PHOTO_PATH_MOBILE;
    }

    return PhotoService::create($request->file('file'), $storage, false, 60, false, 1920);
  }

  /**
   * Delete FIle in dropzone
   *
   * @param Request $request
   * @return JsonResponse
   * @throws BindingResolutionException
   */
  public function photo_delete(Request $request): JsonResponse
  {
    $request->validate([
      'name' => 'required|string',
      'type' => 'required|string'
    ]);

    $data = $request->all();
    if ($data['type'] !== 'mobile' && $data['type'] !== 'desktop') {
      $data['type'] = 'desktop';
    }
    if ($data['type'] === 'desktop') {
      $storage = Slider::PHOTO_PATH;
    } else {
      $storage = Slider::PHOTO_PATH_MOBILE;
    }

    PhotoService::delete($data['name'], $storage, true);
    return response()->json(['status' => 'success']);
  }
}
