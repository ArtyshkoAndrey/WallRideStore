<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Response;

class FaceBookController extends Controller
{

  /**
   * Products by instagram
   *
   * @return Response
   */
  public function items (): Response
  {
    $products = Product::all();

    return response()
      ->view('api.facebook.items', compact('products'))
      ->header('Content-Type', 'text/xml');
  }
}
