<?php

namespace App\Models;

use App\Exceptions\CouponCodeUnavailableException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CouponCode extends Model
{
  // Постоянно определяйте поддерживаемые типы купонов
  const TYPE_FIXED = 'fixed';
  const TYPE_PERCENT = 'percent';

  public static $typeMap = [
    self::TYPE_FIXED   => 'Фиксированная сумма',
    self::TYPE_PERCENT => 'Процентная',
  ];

  protected $fillable = [
    'name',
    'code',
    'type',
    'value',
    'total',
    'used',
    'min_amount',
    'not_before',
    'not_after',
    'enabled',
  ];
  protected $casts = [
    'enabled' => 'boolean',
  ];
  // указывает, что эти два поля являются типами даты
  protected $dates = ['not_before', 'not_after'];

  protected $appends = ['description'];

  public function getDescriptionAttribute()
  {
    $str = '';

    if ($this->min_amount > 0) {
      $str = 'От '.str_replace('.00', '', $this->min_amount). ' р. ';
    }
    if ($this->type === self::TYPE_PERCENT) {
      return $str.'Скидка '.str_replace('.00', '', $this->value).'%';
    }

    return $str.'до '.str_replace('.00', '', $this->value) . ' р. скидка';
  }

  public function checkAvailable(User $user, $orderAmount = null)
  {
    if (!$this->enabled) {
      throw new CouponCodeUnavailableException('Купон не существует');
    }

    if ($this->total - $this->used <= 0) {
      throw new CouponCodeUnavailableException('Купон был выкуплен');
    }

    if ($this->not_before && $this->not_before->gt(Carbon::now())) {
      throw new CouponCodeUnavailableException('Купон еще не доступен');
    }

    if ($this->not_after && $this->not_after->lt(Carbon::now())) {
      throw new CouponCodeUnavailableException('Срок действия этого купона истек');
    }

    if (!is_null($orderAmount) && $orderAmount < $this->min_amount) {
      throw new CouponCodeUnavailableException('Сумма заказа не соответствует минимальной сумме купона');
    }

    $used = Order::where('user_id', $user->id)
      ->where('coupon_code_id', $this->id)
      ->where(function($query) {
        $query->where(function($query) {
          $query->whereNull('paid_at')
          ->where('closed', false);
        })->orWhere(function($query) {
          $query->whereNotNull('paid_at')
          ->where('refund_status', '!=', Order::REFUND_STATUS_SUCCESS);
        });
      })
      ->exists();
    if ($used) {
      throw new CouponCodeUnavailableException('Вы уже использовали этот купон');
    }
  }

  public function getAdjustedPrice($orderAmount)
  {
    // фиксированная сумма
    if ($this->type === self::TYPE_FIXED) {
      // Чтобы обеспечить надежность системы, нам необходимо сумма заказа не менее 0,01 юаня
      return max(0.01, $orderAmount - $this->value);
    }

    return number_format($orderAmount * (100 - $this->value) / 100, 2, '.', '');
  }

  public function changeUsed($increase = true)
  {
    // Передайте в true, чтобы увеличить использование, иначе уменьшите использование
    if ($increase) {
      // Аналогично проверке инвентаря SKU, здесь необходимо проверить, превысило ли текущее использование общее количество
      return $this->newQuery()->where('id', $this->id)->where('used', '<', $this->total)->increment('used');
    } else {
      return $this->decrement('used');
    }
  }

  public static function findAvailableCode($length = 16)
  {
    do {
      // Создать случайную строку указанной длины и преобразовать ее в верхний регистр
      $code = strtoupper(Str::random($length));
      // Продолжить цикл, если сгенерированный код уже существует
    } while (self::query()->where('code', $code)->exists());
    return $code;
  }

  public function productsEnabled () {
    return $this->belongsToMany('App\Models\Product', 'coupons_products', 'coupon_id', 'product_id');
  }

  public function categoriesEnabled () {
    return $this->belongsToMany('App\Models\Category', 'coupons_categories', 'coupon_id', 'category_id');
  }
}
