<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PaySettingController extends Controller
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
    $setting = Settings::where('key', 'pay')->first();
    return view('admin.pay-setting.index', compact('setting'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return void
   */
  public function create()
  {

  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return void
   */
  public function store(Request $request)
  {

  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return void
   */
  public function show(int $id)
  {

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return void
   */
  public function edit(int $id)
  {

  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @return RedirectResponse
   */
  public function update(Request $request)
  {
    $setting = Settings::where('key', 'pay')->first();
    $params = json_decode($setting->meta);
    foreach ($params->pays as $key =>$param) {
      if ($key == $request->param) {
        $params->pays->{$request->param}->enabled = ($request->ch === '1');
      }
    }
    $setting->meta = json_encode($params);
    $setting->save();
    return redirect()->back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return void
   */
  public function destroy(int $id)
  {

  }

}
