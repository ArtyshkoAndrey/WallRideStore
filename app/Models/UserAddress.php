<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'country',
        'city',
        'street',
        'contact_phone',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function currency() {
      return $this->belongsTo(Currency::class);
    }

    public function getFullAddressAttribute() {
        return "{$this->country}, {$this->city}, {$this->street}";
    }
}
