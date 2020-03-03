<?php


namespace App\Http\Controllers;


use App\Models\City;
use App\Models\Country;

class ApiController extends Controller {

  public function city ($city) {
    $cities = City::whereLike('name', $city)->take(20)->get();
    return ['items' => $cities];
  }

  public function country ($country) {
    $countries = Country::whereLike('name', $country)->get();
    return ['items' => $countries];
  }
}
