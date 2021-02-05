<?php
/*
* Copyright (c) 2020. Данный файл является интелектуальной собственостью Fulliton.
* Я буду рад если вы будите вносить улучшения, всегда жду ваших пул реквестов
*/

namespace App\Models;

use Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'avatar',
    'email',
    'password',
    'address',
    'post_code',
    'is_admin',
    'phone',
    'notification',
    'old_notification'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'is_admin' => 'boolean',
    'notification' => 'boolean',
    'old_notification' => 'boolean',
  ];

  /**
   * User city
   *
   * @return BelongsTo
   */
  public function city (): BelongsTo
  {
    return $this->belongsTo(City::class);
  }

  /**
   * User country
   *
   * @return BelongsTo
   */
  public function country (): BelongsTo
  {
    return $this->belongsTo(Country::class);
  }

  public function currency (): belongsTo
  {
    return $this->belongsTo(Currency::class);
  }

  public function getAvatarImageAttribute (): string
  {
    return $this->avatar ? asset('storage/avatar/' . $this->avatar) : asset('images/product.jpg');
  }
}
