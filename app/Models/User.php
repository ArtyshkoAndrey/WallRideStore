<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\PasswordReset;

class User extends Authenticatable
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  public function address()
  {
    return $this->hasOne(UserAddress::class);
  }

  public function favoriteProducts()
  {
    return $this->belongsToMany(Product::class, 'user_favorite_products')
      ->withTimestamps()
      ->orderBy('user_favorite_products.created_at', 'desc');
  }

  public function cartItems()
  {
    return $this->hasMany(CartItem::class);
  }

  public function sendPasswordResetNotification($token)
  {
    $this->notify(new PasswordReset($token));
  }
}
