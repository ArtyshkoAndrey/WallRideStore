<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Intervention\Image\ImageManagerStatic as Image;

class NewsController extends Controller
{

  public function __construct()
  {
//    parent::__construct($cartService);
  }

  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return Factory|View
   */
    public function index(Request $request)
    {
      $type = $request->type;
      $search = $request->search;
      $news = News::query();

      if (isset($search)) {
        if ($type === 'delete') {
          $news = $news->onlyTrashed()->where('title', 'LIKE', '%'.$search.'%');
        } else {
          $news = $news->where('title', 'LIKE', '%'.$search.'%');
        }
      } else {
        $search = '';
      }

      if (isset($type)) {
        switch ($type) {
          case 'publish':
            break;
          case 'all':
            $news = $news->withTrashed();
            break;
          case 'delete':
            $news = $news->onlyTrashed();
            break;
        }
      } else {
        $type = 'publish';
      }

      $news = $news->orderByDesc('created_at');
      $news = $news->paginate(5);
      $filters = [
        'type'  => $type,
        'search'=> $search
      ];

      return view('admin.news.index', compact('news', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
      return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
//      dd($request);
      $request->validate([
        'title' => 'required',
        'content' => 'required'
      ]);
      $n = News::create($request->all());

      return redirect()->route('admin.news.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Factory|View
     */
    public function edit($id)
    {
      $n = News::withTrashed()->find($id);
      return view('admin.news.edit', compact('n'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
      $request->validate([
        'title' => 'required',
        'content' => 'required'
      ]);
      $n = News::withTrashed()->find($id);
      $n->update($request->all());
      $n->save();
      return redirect()->route('admin.news.index');
    }

    /**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return RedirectResponse
 */
  public function destroy($id)
  {
    $n = News::withTrashed()->find($id);
    if($n->trashed()) {
      File::delete(public_path('storage/news/') . '/' . $n->photo);
      $n->forceDelete();
    } else {
      $n->delete();
    }
    return redirect()->back();
  }

  /**
   * Restore the specified resource from storage.
   *
   * @param  int  $id
   * @return RedirectResponse
   */
  public function restore($id)
  {
    News::onlyTrashed()->find($id)->restore();
    return redirect()->back();
  }

  public function photoDelete(Request $request) {
    $n = News::withTrashed()->where('photo', $request->name)->first();
    if($n) {
      $n->photo = null;
      $n->save();
    }
    File::delete(public_path('storage/news/') . '/' .$request->name);
    return $request->name;
  }

  public function photoCreate(Request $request) {
    $image = $request->file('file');
    $destinationPath = public_path('storage/news/');
    $name = $request->file('file')->getClientOriginalName();
    $img = Image::make($image->getRealPath());
    $img->save($destinationPath.'/'.$name);
    if(isset($request->id)) {
      $n = News::withTrashed()->find($request->id);
      $n->photo = $name;
      $n->save();
    }
    return $name;
  }
}
