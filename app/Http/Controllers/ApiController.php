<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductSku;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Country;
use App\Models\ExpressCompany;
use App\Models\ExpressZone;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller {

  public function city ($city, $country = null) {
    if ($country === null)
      $cities = City::whereLike('name', $city)->take(20)->get();
    else
      $cities = City::whereHas('country', function ($q) use($country) {
        $q->where('countries.id', $country);
      })->whereLike('name', $city)->take(20)->get();
    return ['items' => $cities];
  }

  public function country ($country) {
    $countries = Country::whereLike('name', $country)->get();
    return ['items' => $countries];
  }

  public function category ($category) {
    $categories = Category::whereLike('name', $category)->get();
    return ['items' => $categories];
  }

  public function brand ($brand) {
    $brands = Brand::whereLike('name', $brand)->get();
    return ['items' => $brands];
  }

  public function companies(Request $request) {
    $express_companies = ExpressCompany::where('name', '!=', 'Самовывоз')->get();
    $zones = ExpressZone::with('company')->whereHas('cities', function ($qq) use ($request) {
      $qq->where('cities.id', $request->city);
    })->get();
    $express_companies = $express_companies->toArray();
    for($i=0;$i<count($express_companies); $i++) {
      foreach ($zones as $z) {
        if($z->company->id === $express_companies[$i]['id']) {
          $express_companies[$i]['costedTransfer'] = $z->cost;
          $express_companies[$i]['step_unlim'] = $z->step;
          $express_companies[$i]['step_cost_unlim'] = $z->cost_step;
        }
      }
      if (!isset($express_companies[$i]['costedTransfer'])) {
        $express_companies[$i]['costedTransfer'] = null;
        $express_companies[$i]['step_unlim'] = null;
        $express_companies[$i]['step_cost_unlim'] = null;
      }
    }
    return $express_companies;
  }
}
