<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faqs;
use App\Services\PhotoService;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FAQController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return Application|Factory|View
   */
  public function index(Request $request)
  {
    $faqs = Faqs::query();
    $filter = [];
    if ($filter['title'] = $request->get('title')) {
      $faqs = $faqs->whereTranslationLike('title', '%' . $filter['title'] . '%');
    }
    $faqs = $faqs->paginate(15);

    return view('admin.faq.index', compact('faqs', 'filter'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|View
   */
  public function create()
  {
    return view('admin.faq.create');
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
      'ru.title' => 'required|string',
      'en.title' => 'required|string',
      'ru.content' => 'required|string',
      'en.content' => 'required|string',
      'image' => 'required|string'
    ]);

    $data = $request->all();

    $post = Faqs::create($data);
    $post->save();

    return redirect()->route('admin.faq.index')->with('success', ['FAQ успешно создана']);
  }

  /**
   * Display the specified resource.
   *
   * @param Faqs $faq
   * @return void
   */
  public function show(Faqs $faq): void
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param Faqs $faq
   * @return Application|Factory|View
   */
  public function edit(Faqs $faq)
  {
    return view('admin.faq.edit', compact('faq'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param Faqs $faq
   * @return RedirectResponse
   */
  public function update(Request $request, Faqs $faq): RedirectResponse
  {
    $request->validate([
      'ru.title' => 'required|string',
      'en.title' => 'required|string',
      'ru.content' => 'required|string',
      'en.content' => 'required|string',
      'image' => 'required|string'
    ]);

    $data = $request->all();

    $faq->update($data);

    return redirect()->route('admin.faq.index')->with('success', ['FAQ успешно обновлена']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Faqs $faq
   * @return RedirectResponse
   * @throws Exception
   */
  public function destroy(Faqs $faq): RedirectResponse
  {
    $faq->delete();
    return redirect()->route('admin.faq.index')->with('success', ['Faqs $faq успешно удалена']);
  }

  /**
   * Save Photo in tiny textarea
   *
   * @param Request $request
   * @return JsonResponse
   * @throws BindingResolutionException
   */
  public function content_mage(Request $request): JsonResponse
  {
    $request->validate([
      'file' => 'required|image',
    ]);

    $imgPath = $request->file('file')->storeAs(
      mb_substr(Faqs::PHOTO_CONTENT_PATH, 0, -1),
      time() . '.' . $request->file('file')->extension(),
      ['disk' => 'tiny']
    );
    return response()->json(['location' => url($imgPath)]);
  }

  public function photo_store(Request $request): string
  {
    $request->validate([
      'file' => 'required|image',
    ]);
    return PhotoService::create($request->file('file'), Faqs::PHOTO_PATH, true, 60, true, 1200);
  }

  public function photo_delete(Request $request): JsonResponse
  {
    $request->validate([
      'name' => 'required|string'
    ]);
    PhotoService::delete($request->name, Faqs::PHOTO_PATH, true);
    return response()->json(['status' => 'success']);
  }
}
