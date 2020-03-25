<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\ExpressCompany;
use App\Models\ExpressZone;

class ApiController extends Controller {

  public function city ($city) {
    $cities = City::whereLike('name', $city)->take(20)->get();
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
        }
      }
      if (!isset($express_companies[$i]['costedTransfer'])) {
        $express_companies[$i]['costedTransfer'] = null;
      }
    }
    return $express_companies;
  }
}
