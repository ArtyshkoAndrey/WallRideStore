<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\PhotoService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return Application|Factory|View
   */
  public function index(Request $request)
  {
    $posts = Post::query();
    $filter = [];
    if ($filter['title'] = $request->get('title')) {
      $posts = $posts->whereTranslationLike('title', '%' . $filter['title'] . '%');
    }
    $posts = $posts->paginate(15);

    return view('admin.post.index', compact('posts', 'filter'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|View
   */
  public function create()
  {
    return view('admin.post.create');
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
      'ru.short_content' => 'required|string',
      'en.short_content' => 'required|string',
      'photo' => 'required|string'
    ]);

    $data = $request->all();

    $post = Post::create($data);
    $post->save();

    return redirect()->route('admin.post.index')->with('success', ['Новость успешно создана']);
  }

  /**
   * Display the specified resource.
   *
   * @param Post $post
   * @return void
   */
  public function show(Post $post): void
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param Post $post
   * @return Application|Factory|View
   */
  public function edit(Post $post)
  {
    return view('admin.post.edit', compact('post'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param Post $post
   * @return RedirectResponse
   */
  public function update(Request $request, Post $post): RedirectResponse
  {
    $request->validate([
      'ru.title' => 'required|string',
      'en.title' => 'required|string',
      'ru.content' => 'required|string',
      'en.content' => 'required|string',
      'ru.short_content' => 'required|string',
      'en.short_content' => 'required|string',
      'photo' => 'required|string'
    ]);

    $data = $request->all();

    $post->update($data);

    return redirect()->route('admin.post.index')->with('success', ['Новость успешно обновлена']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Post $post
   * @return RedirectResponse
   * @throws Exception
   */
  public function destroy(Post $post): RedirectResponse
  {
    $post->delete();
    return redirect()->route('admin.post.index')->with('success', ['Новость успешно удалена']);
  }

  /**
   * Save Photo in tiny textarea
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function content_mage(Request $request): JsonResponse
  {
    $request->validate([
      'file' => 'required|image',
    ]);
    $imgPath = $request->file('file')->storeAs(
      mb_substr(Post::PHOTO_CONTENT_PATH, 0, -1),
      time() . '.' . $request->file('file')->extension(),
      ['disk' => 'tiny']
    );
    return response()->json(['location' => url($imgPath)]);
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
    return PhotoService::create($request->file('file'), Post::PHOTO_PATH, true, 60, 1200);
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
      'name' => 'required|string'
    ]);
    PhotoService::delete($request->name, Post::PHOTO_PATH, true);
    return response()->json(['status' => 'success']);
  }
}
