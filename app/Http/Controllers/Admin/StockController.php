<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ListenerStockUser;
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
//    TODO: Допилить валидацию новых полей
    $request->validate([
      'title' => 'required',
      'view' => 'required',
      'description' => 'required',
      'text_to_link' => 'required'
    ]);
//    dd($request->all());
    $data = $request->all();
    if ($data['view'] != 3) {
      $request->validate([
        'link' => 'required'
      ]);
    }
    $data['on_auth'] = isset($request->on_auth);
    $st = Stock::create($data);
    if ($st->on_auth) {
      ListenerStockUser::dispatch($st, (int) $request->delay);
    }
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
      'view' => 'required',
      'description' => 'required',
      'text_to_link' => 'required'
    ]);
    $st = Stock::find($id);
    $data = $request->all();
    $data['on_auth'] = isset($request->on_auth);
    if ($data['view'] != 3) {
      $request->validate([
        'link' => 'required'
      ]);
    }
    if ($data['on_auth']) {
      $st->delete();
      $st = Stock::create($data);
      ListenerStockUser::dispatch($st, (int) $request->delay);
      return redirect()->route('admin.store.stock.index');
    }
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
    if($st->image) {
      File::delete(public_path('storage/stocks/') . '/' . $st->image);
    }
    $st->delete();
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
