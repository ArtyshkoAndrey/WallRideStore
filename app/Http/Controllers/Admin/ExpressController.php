<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExpressCompany;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ExpressController extends Controller
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
    $expresses = ExpressCompany::all();
    return view('admin.express.index', compact('expresses'));
  }

  public function enabled(Request $request, $id) {
//    dd($request);
    $express = ExpressCompany::find($id);
    $express->enabled = $request->enabled;
    $express->save();
    return redirect()->route('admin.store.express.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      //
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
    $express = ExpressCompany::find($id);
    return view('admin.express.edit', compact('express'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      //
  }
}
