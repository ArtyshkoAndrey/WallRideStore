<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Modal;
use App\Models\Slider;
use App\Services\PhotoService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ModalController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|View
   */
  public function index(Request $request)
  {
    $modals = Modal::query();
    $title = $request->get('title');
    if ($title) {
      $modals = $modals->whereTranslation('title', $title);
    }

    $filter = [
      'title' => $title
    ];
    $modals = $modals->paginate(7);
    $modals->appends($filter);
    return view('admin.modal.index', compact('modals', 'filter'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|View
   */
  public function create()
  {
    return view('admin.modal.create');
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
      'ru.title' => 'required',
      'en.title' => 'required',
      'type'     => 'required|integer'
    ]);

    $data = $request->all();

    if ((int) $request->get('type') === 1) {
      $request->validate([
        'ru.description'  => 'required',
        'en.description'  => 'required',
        'link'            => 'required',
        'image'           => 'required',
        'ru.text_to_link' => 'required',
        'en.text_to_link' => 'required',
      ]);

      $modal = new Modal($request->all());
      $modal->save();
    } else if ((int) $request->get('type') === 2) {
      $request->validate([
        'ru.description'  => 'required',
        'en.description'  => 'required',
        'link'            => 'required',
        'ru.text_to_link' => 'required',
        'en.text_to_link' => 'required',
      ]);

      $modal = new Modal($request->all());
      $modal->save();
    } else if ((int) $request->get('type') === 3) {
      $request->validate([
        'ru.description'  => 'required',
        'en.description'  => 'required',
        'ru.text_to_link' => 'required',
        'en.text_to_link' => 'required',
      ]);
      $modal = new Modal($request->all());
      $modal->save();
    } if ((int) $request->get('type') === 4) {
      $request->validate([
        'ru.description'  => 'required',
        'en.description'  => 'required',
      ]);
      $modal = new Modal($request->all());
      $modal->save();
    } else {
      return redirect()->back()->withInput()->with('error', ['Ошибка при сохранении']);
    }

    return redirect()->route('admin.modal.index')->with('success', ['Модальное окноуспешно создано']);
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
   * @param int $id
   * @return Application|Factory|View
   */
  public function edit(int $id)
  {
    $modal = Modal::find($id);
    return view('admin.modal.edit', compact('modal'));
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
      'ru.title' => 'required',
      'en.title' => 'required',
      'type'     => 'required|integer'
    ]);

    $data = $request->all();
    $modal = Modal::find($id);

    if ((int) $request->get('type') === 1) {
      $request->validate([
        'ru.description'  => 'required',
        'en.description'  => 'required',
        'link'            => 'required',
        'image'           => 'required',
        'ru.text_to_link' => 'required',
        'en.text_to_link' => 'required',
      ]);

      $modal->update($data);
      $modal->save();
    } else if ((int) $request->get('type') === 2) {
      $request->validate([
        'ru.description'  => 'required',
        'en.description'  => 'required',
        'link'            => 'required',
        'ru.text_to_link' => 'required',
        'en.text_to_link' => 'required',
      ]);
      $data['image'] = $data['image'] ?? null;
      $modal->update($data);
      $modal->save();
    } else if ((int) $request->get('type') === 3) {
      $request->validate([
        'ru.description'  => 'required',
        'en.description'  => 'required',
        'ru.text_to_link' => 'required',
        'en.text_to_link' => 'required',
      ]);
      $data['image'] = $data['image'] ?? null;
      $modal->update($data);
      $modal->save();
    } else {
      return redirect()->back()->withInput()->with('error', ['Ошибка при сохранении']);
    }

    return redirect()->route('admin.modal.index')->with('success', ['Модальное окноуспешно создано']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function destroy(int $id): RedirectResponse
  {
    $modal = Modal::find($id);
    if ($modal) {
      $modal->delete();
    }

    return redirect()->route('admin.modal.index')->with('success', ['Модальное окноуспешно удалено']);
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
    ]);

    $storage = Modal::PHOTO_PATH;

    return PhotoService::create($request->file('file'), $storage, false, 60, false, 1200);
  }

  /**
   * Delete FIle in dropzone
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function photo_delete(Request $request): JsonResponse
  {
    $request->validate([
      'name' => 'required|string',
    ]);

    $data = $request->all();
    $storage = Modal::PHOTO_PATH;

    PhotoService::delete($data['name'], $storage, true);
    return response()->json(['status' => 'success']);
  }
}
