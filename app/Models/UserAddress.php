<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
  protected $fillable = [
    'street',
    'contact_phone',
  ];

  public function getFullAddressAttribute () {
    return "{$this->country->name}, {$this->city->name}, {$this->street}";
  }

  public function user () {
    return $this->belongsTo(User::class);
  }

  public function currency () {
    return $this->belongsTo(Currency::class);
  }

  public function city () {
    return $this->belongsTo(City::class);
  }

  public function country () {
    return $this->belongsTo(Country::class);
  }
}
