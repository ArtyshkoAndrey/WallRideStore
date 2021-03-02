<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class CartController extends Controller
{

  /**
   * Cart page
   * @return View
   */
  public function index(): View
  {
    return view('user.cart.index');
  }
}
