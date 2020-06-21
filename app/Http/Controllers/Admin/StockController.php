<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Stock;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Intervention\Image\ImageManagerStatic as Image;

class StockController extends Controller
{

  public function __construct()
  {
//    parent::__construct($cartService);
  }

  /**
   * Display a listing of the resource.
   *
   * @return Factory|View
   */
  public function index()
  {
    $stocks = Stock::all();
    return view('admin.stock.index', compact('stocks'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Factory|View
   */
  public function create()
  {
    return view('admin.stock.create');
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
    ]);
    $st = Stock::create($request->all());
    return redirect()->route('admin.store.stock.index');
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
    $st = Stock::find($id);
    return view('admin.stock.edit', compact('st'));
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
    ]);
    $st = Stock::find($id);
    $st->update($request->all());
    $st->save();
    return redirect()->route('admin.store.stock.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return RedirectResponse
   */
  public function destroy($id)
  {
    $st = Stock::find($id);
    if($st) {
//      File::delete(public_path('storage/stocks/') . '/' . $st->image);
      $st->delete();
    }
    return redirect()->back();
  }

  public function photoDelete(Request $request) {
    $st = Stock::where('image', $request->name)->first();
    if($st) {
      $st->image = null;
      $st->save();
    }
    File::delete(public_path('storage/stocks/') . '/' .$request->name);
    return $request->name;
  }

  public function photoCreate(Request $request) {
    $image = $request->file('file');
    $destinationPath = public_path('storage/stocks/');
    $name = $request->file('file')->getClientOriginalName();
    $img = Image::make($image->getRealPath());
    $img->save($destinationPath.'/'.$name);
    if(isset($request->id)) {
      $st = Stock::find($request->id);
      $st->image = $name;
      $st->save();
    }
    return $name;
  }
}
