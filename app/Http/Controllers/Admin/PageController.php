<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PageController extends Controller {

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __constructor()
  {
    $this->middleware('auth:admin');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function index() {
    return view('admin.dashboard');
  }

}
