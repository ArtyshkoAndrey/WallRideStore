<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Services\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PromotionController extends Controller {

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
    $promotions = Promotion::all();
    return view('admin.promotion.index', compact('promotions'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Factory|View
   */
  public function create()
  {
    return view('admin.promotion.create');
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
      'name' => 'required',
      'sale' => 'required|integer|min:0|max:100',
      'count_product' => 'required|integer|min:1|max:255',
    ]);
    $r = $request->all();
    $r['status'] = $request->has('status');
    $r['sale_status'] = !$request->has('sale_status');
    Promotion::create($r);
    return redirect()->route('admin.production.promotions.index');
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
    $promotion = Promotion::find($id);
    return view('admin.promotion.edit', compact('promotion'));
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
      'name' => 'required',
      'sale' => 'required|min:0|max:100',
      'count_product' => 'required|min:1|max:255',
    ]);
    $pr = Promotion::find($id);
    $r = $request->all();
    $r['status'] = $request->has('status');
    $r['sale_status'] = !$request->has('sale_status');
    $pr->update($r);
    $pr->save();
    return redirect()->route('admin.production.promotions.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return RedirectResponse
   */
  public function destroy($id)
  {
    $f = Promotion::find($id);
    $f->delete();
    return redirect()->back();
  }
}
