<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

  protected $fillable = [
    'name',
  ];

  public function scopeWhereLike ($query, $column, $value)
  {
    return $query->where($column, 'like', '%'.$value.'%');
  }

  public function cities () {
    return $this->hasMany(City::class, 'country_id', 'id');
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
    $countries = Country::whereNotIn('name', $notTranslateCountries)
      ->get();
    foreach ($countries as $country) {
      $json = array_add($json, $country->id, $country->name);
    }
    $filename = "countries.json";
    $fh = fopen(public_path('storage/' . $filename), "a");
    fwrite($fh, json_encode($json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    fclose($fh);
  }

  public static function translateToEn () {
    $filename = "countries_en.json";
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
    $fh = fopen(public_path('storage/' . $filename), "r");
    $json = fread($fh, filesize(public_path('storage/' . $filename)));
    fclose($fh);
    $countries = json_decode($json);

    foreach ($countries as $id => $name) {
      if (!in_array(Country::find($id)->name, $notTranslateCountries))
        Country::find($id)->update(['name' => $name]);
    }
  }
}
