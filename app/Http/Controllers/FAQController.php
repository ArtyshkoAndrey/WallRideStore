<?php


namespace App\Http\Controllers;

use App\Services\CartService;
use App\Models\FAQ;

class FAQController extends Controller {
  public function __construct(CartService $cartService)
  {
    parent::__construct($cartService);
  }

  public function index () {
    $faqs = FAQ::all();
    return view('faq.index', compact('faqs'));
  }
  public function show ($id) {
    $f = FAQ::find($id);
    if($f) {
      return view('faq.show', compact('f'));
    } else {
      return abort(404);
    }

  }

}
