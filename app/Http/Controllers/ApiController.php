<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{

  /**
   * Displaying countries by search
   * @param Request $request
   * @return JsonResponse
   */
  public function countries(Request $request): JsonResponse
  {
    if ($name = $request->get('name')) {
      $countries = Country::where('name', 'like', '%' . $name . '%')->limit(5)->get();
    } else {
      $countries = Country::limit(5)->get();
    }
    return response()->json(['countries' => $countries]);
  }

  /**
   * Displaying categories by search
   * @param Request $request
   * @return JsonResponse
   */
  public function categories(Request $request): JsonResponse
  {
    if ($name = $request->get('name')) {
      $categories = Category::where('name', 'like', '%' . $name . '%')->limit(5)->get();
    } else {
      $categories = Category::limit(5)->get();
    }
    return response()->json(['categories' => $categories]);
  }

  /**
   * Displaying cities by search
   * @param Request $request
   * @return JsonResponse
   */
  public function cities(Request $request): JsonResponse
  {
    if ($name = $request->get('name', null)) {
      $cities = City::where('name', 'like', '%' . $name . '%')->limit(5)->get();
    } else {
      $cities = City::limit(5)->get();
    }
    return response()->json(['cities' => $cities]);
  }

  /**
   * Conclusion of brands by search
   * @param Request $request
   * @return JsonResponse
   */
  public function brands(Request $request): JsonResponse
  {
    $name = $request->get('name');
    if ($name && $name !== '') {
      $brands = Brand::where('name', 'like', '%' . $name . '%')->limit(5)->get();
    } else {
      $brands = Brand::limit(5)->get();
    }
    return response()->json(['brands' => $brands]);
  }

  /**
   * Checking for auth and outputting user data
   * @return JsonResponse
   */
  public function check(): JsonResponse
  {
    $check = Auth::check();
    $user = Auth::user();
    return response()->json(['auth' => $check, 'user' => $user]);
  }
}
