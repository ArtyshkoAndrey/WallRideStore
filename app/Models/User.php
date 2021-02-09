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

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $avatar
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $address
 * @property string|null $post_code
 * @property string|null $phone
 * @property bool $notification
 * @property bool $old_notification
 * @property int|null $currency_id
 * @property bool $is_admin
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\City $city
 * @property-read \App\Models\Country $country
 * @property-read \App\Models\Currency|null $currency
 * @property-read string $avatar_image
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAddress($value)
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereCurrencyId($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIsAdmin($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User whereNotification($value)
 * @method static Builder|User whereOldNotification($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User wherePostCode($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 */
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
