<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\PasswordReset;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;

class User extends Authenticatable
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password', 'notification', 'avatar', 'old_notification'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  protected $casts = [
    'notification' => 'boolean',
    'old_notification' => 'boolean'
  ];

  public function address ()
  {
    return $this->hasOne(UserAddress::class);
  }

  public function orders (): HasMany
  {
    return $this->hasMany(Order::class, 'user_id', 'id');
  }

  public function favoriteProducts ()
  {
    return $this->belongsToMany(Product::class, 'user_favorite_products')
      ->withTimestamps()
      ->orderBy('user_favorite_products.created_at', 'desc');
  }

  public function cartItems ()
  {
    return $this->hasMany(CartItem::class);
  }

  public function sendPasswordResetNotification ($token)
  {
    $this->notify(new PasswordReset($token));
  }

  public function checkedStockView (Stock $stock): bool
  {
    if (DB::table('users_stocks')->where('user_id', $this->id)->where('stock_id', $stock->id)->exists()) {
      $data = DB::table('users_stocks')->where('user_id', $this->id)->where('stock_id', $stock->id)->first();
      return $data->view === 0 ? false : true;
    } else {
      DB::table('users_stocks')->insert(['user_id' => $this->id, 'stock_id' => $stock->id, 'view' => false]);
      return false;
    }
  }

  public function changeStockView (Stock $stock, $value)
  {
    if (DB::table('users_stocks')->where('user_id', $this->id)->where('stock_id', $stock->id)->exists()) {
      DB::transaction(function() use ($stock, $value) {
        DB::table('users_stocks')->where('user_id', $this->id)->where('stock_id', $stock->id)->update(['view' => $value]);
      });
    } else {
      DB::table('users_stocks')->insert(['user_id' => $this->id, 'stock_id' => $stock->id, 'view' => $value]);
    }
  }
}
