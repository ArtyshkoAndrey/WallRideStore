<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
  protected $fillable = [
    'name',
  ];

  public function country () {
    return $this->hasOne(Country::class, 'id', 'country_id');
  }

  public function scopeWhereLike($query, $column, $value)
  {
    return $query->where($column, 'like', '%'.$value.'%');
  }

  public static function translate () {
    $json = [];
    $notTranslateCountries = ['Казахстан',
      'Азербайджан',
      'Беларусь',
      'Кыргызстан',
      'Молдова',
      'Таджикистан',
      'Узбекистан',
      'Россия',
      'Армения',
      'Украина',
      'Абхазия'];
    $cities = City::whereDoesntHave('country', function ($q) use($notTranslateCountries) {
      $q->whereIn('countries.name', $notTranslateCountries);
    })->get();
    foreach ($cities as $city) {
      $json = array_add($json, $city->id, $city->name);
    }
    $filename = "cities.json";
    $fh = fopen(public_path('storage/' . $filename), "a");
    fwrite($fh, json_encode($json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    fclose($fh);
  }

  public static function translateToEn () {
    $notTranslateCountries = ['Казахстан',
      'Азербайджан',
      'Беларусь',
      'Кыргызстан',
      'Молдова',
      'Таджикистан',
      'Узбекистан',
      'Россия',
      'Армения',
      'Украина',
      'Абхазия'];

    $filenames = [
      '2534-4788-cities_en.json',
      '4789-6825-cities_en.json',
      '6826-8876-cities_en.json',
//      '8877-11139-cities_en.json',
//      '11140-13331-cities_en.json',
//      '13332-15643-cities_en.json',
//      '15644-17589-cities_en.json'
    ];
    foreach ($filenames as $filename) {
      $fh = fopen(public_path('storage/' . $filename), "r");
      $json = fread($fh, filesize(public_path('storage/' . $filename)));
      fclose($fh);
      $cities = json_decode($json);
      foreach ($cities as $id => $name) {
        if (!in_array(($city = City::find($id))->country->name, $notTranslateCountries))
          $city->update(['name' => $name]);
      }
    }
  }
}
