<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\ProductSku;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Country;
use App\Models\ExpressCompany;
use App\Models\ExpressZone;
use Illuminate\Support\Facades\Auth;
use App\Services\OrderService;

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
          if ($z->step_cost_array !== null) {
            $express_companies[$i]['costedTransfer'] = $z->step_cost_array;
            $express_companies[$i]['step_unlim'] = null;
            $express_companies[$i]['step_cost_unlim'] = null;
          } else {
            $express_companies[$i]['costedTransfer'] = $z->cost;
            $express_companies[$i]['step_unlim'] = $z->step;
            $express_companies[$i]['step_cost_unlim'] = $z->cost_step;
          }
        }
      }
      if (!isset($express_companies[$i]['costedTransfer'])) {
        $express_companies[$i]['costedTransfer'] = null;
        $express_companies[$i]['costedTransfer'] = null;
        $express_companies[$i]['step_unlim'] = null;
        $express_companies[$i]['step_cost_unlim'] = null;
      }
    }
    return $express_companies;
  }

  public function delete_orders (OrderService $orderService) {
    $date = Carbon::now();
    dump($date);
    dump($date->subHours(2));
    $orders = Order::where('ship_status', Order::SHIP_STATUS_PAID)->where('created_at','<', $date)->get();
    foreach ($orders as $order) {
      $orderService->cancled($order);
    }
  }
}
