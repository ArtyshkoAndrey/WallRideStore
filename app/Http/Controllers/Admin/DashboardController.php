<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Services\CartService;

class DashboardController extends Controller
{

  public function __construct(CartService $cartService)
  {
//    parent::__construct($cartService);
  }

  public function index () {
    return view('admin.dashboard');
  }

  public function status (Request $request) {
    (new Settings)->statusSite((int)$request->has('status'));
    return redirect()->back();
  }

}
