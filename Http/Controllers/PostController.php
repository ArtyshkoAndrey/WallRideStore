<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Cache;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
    $posts = Post::orderByDesc('created_at')
      ->paginate(6);
    return view('user.post.index', compact('posts'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return void
   */
  public function create(): void
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return void
   */
  public function store(Request $request): void
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param Post $post
   * @return Application|Factory|View
   */
  public function show(Post $post)
  {
    return view('user.post.show', compact('post'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return void
   */
  public function edit(int $id): void
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param int $id
   * @return void
   */
  public function update(Request $request, int $id): void
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return void
   */
  public function destroy(int $id): void
  {
    //
  }
}
