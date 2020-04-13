<?php

namespace App\Http\Controllers\Admin;

use App\Models\Header;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class HeaderController extends Controller
{
  public function __construct()
  {
//    parent::__construct($cartService);
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
      $hs = Header::all();
      return view('admin.header.index', compact('hs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.header.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
        'url' => 'required',
        'btn_text' => 'required',
        'photo' => 'required',
        'h1' => 'required',
        'h2' => 'required',
      ]);

      $h = new Header($request->all());
      $h->save();
      return redirect()->route('admin.header.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $h = Header::find($id);
      return view('admin.header.edit', compact('h'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
      $request->validate([
        'url' => 'required',
        'btn_text' => 'required',
        'photo' => 'required',
        'h1' => 'required',
        'h2' => 'required',
      ]);

      $h = Header::find($id);
      $h->update($request->all());
      $h->save();
      return redirect()->route('admin.header.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $h = Header::find($id);
      File::delete(public_path('storage/header/') . '/' .$h->photo);
      $h->delete();
      return redirect()->route('admin.header.index');
    }

  public function photoDelete(Request $request) {
    $h = Header::where('photo', $request->name)->first();
    if($h) {
      $h->photo = null;
      $h->save();
    }
    File::delete(public_path('storage/header/') . '/' .$request->name);
    return $request->name;
  }

  public function photoCreate(Request $request) {
    $image = $request->file('file');
    $destinationPath = public_path('storage/header/');
    $name = $request->file('file')->getClientOriginalName();
    $img = Image::make($image->getRealPath());
    $img->save($destinationPath.'/'.$name);
    if(isset($request->id)) {
      $n = Header::find($request->id);
      if ($n) {
        $n->photo = $name;
        $n->save();
      }
    }
    return $name;
  }
}
