<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use App\Services\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Intervention\Image\ImageManagerStatic as Image;

class FAQController extends Controller {

  public function __construct(CartService $cartService)
  {

  }
  /**
   * Display a listing of the resource.
   *
   * @return Factory|View
   */
  public function index()
  {
    $faqs = FAQ::all();
    return view('admin.faq.index', compact('faqs'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Factory|View
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
  public function store(Request $request)
  {
    $request->validate([
      'title' => 'required',
      'image' => 'required',
      'content' => 'required'
    ]);
    FAQ::create($request->all());
    return redirect()->route('admin.store.faqs.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
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
    $f = FAQ::find($id);
    return view('admin.faq.edit', compact('f'));
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
      'image' => 'required',
      'content' => 'required'
    ]);
    $f = FAQ::find($id);
    $f->update($request->all());
    $f->save();
    return redirect()->route('admin.store.faqs.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return RedirectResponse
   */
  public function destroy($id)
  {
    $f = FAQ::find($id);
    if($f->image) {
      File::delete(public_path('storage/faq/') . '/' . $f->image);
    }
    $f->delete();
    return redirect()->back();
  }

  public function photoDelete(Request $request) {
    $f = FAQ::where('image', $request->name)->first();
    if($f) {
      $f->image = 'no image';
      $f->save();
    }
    File::delete(public_path('storage/faq/') . '/' .$request->name);
    return $request->name;
  }

  public function photoCreate(Request $request) {
    $image = $request->file('file');
    $destinationPath = public_path('storage/faq/');
    $name = $request->file('file')->getClientOriginalName();
    $img = Image::make($image->getRealPath());
    $img->save($destinationPath.'/'.$name);
    if(isset($request->id)) {
      $st = FAQ::find($request->id);
      $st->image = $name;
      $st->save();
    }
    return $name;
  }
}
