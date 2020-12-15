<?php

namespace App\Models;

use App\Exceptions\CouponCodeUnavailableException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany as BelongsToManyAlias;
use Illuminate\Support\Str;

class CouponCode extends Model
{
  // Постоянно определяйте поддерживаемые типы купонов
  const TYPE_FIXED   = 'fixed';
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
    'max_amount',
    'not_before',
    'not_after',
    'enabled',
    'disabled_other_sales',
    'disabled_other_coupons',
    'notification'
  ];
  protected $casts = [
    'enabled'                => 'boolean',
    'disabled_other_coupons' => 'boolean',
    'disabled_other_sales'   => 'boolean',
    'notification'           => 'boolean'
  ];
  // указывает, что эти два поля являются типами даты
  protected $dates = ['not_before', 'not_after', ];

  protected $appends = ['description'];

  public function getDescriptionAttribute (): string
  {
    $str = '';

    if ($this->min_amount > 0) {
      $str = 'От '.str_replace('.00', '', $this->min_amount). ' тг. ';
    }
    if ($this->type === self::TYPE_PERCENT) {
      return $str.'Скидка '.str_replace('.00', '', $this->value).'%';
    }

    return $str.'до '.str_replace('.00', '', $this->value) . ' тг. скидка';
  }

  public function checkAvailable ($orderAmount = null)
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
  }

  public function getAdjustedPrice ($items): int
  {
    // фиксированная сумма
    $price = 0;
//    disabled_other_sales
//    return (int) number_format($orderAmount * (100 - $this->value) / 100, 2, '.', '');
    if ($this->type === self::TYPE_PERCENT) {
      // Чтобы обеспечить надежность системы, нам необходимо сумма заказа не менее 0,01 юаня
//      return (int) max(0.01, $orderAmount - $this->value);
      foreach($items as $item) {
        // Проверка что купон делает скидку на скидочные товары и товар со скидкой
        if ($item['productSku']['product']['on_sale'] && !$this->disabled_other_sales) {
          $price += (int) ( (int) $item['productSku']['product']['price_sale'] * (int) $item['amount'] * ((100 - $this->value) / 100) );
        } else if($item['productSku']['product']['on_sale'] && $this->disabled_other_sales) {
          $price += (int) $item['productSku']['product']['price_sale'] * (int) $item['amount'];
        } else {
          $price += (int) ( (int) $item['productSku']['product']['price'] * (int) $item['amount'] * ((100 - $this->value) / 100) );
        }
      }
      return (int) $price;
    }

    if ($this->type === self::TYPE_FIXED) {
      // Чтобы обеспечить надежность системы, нам необходимо сумма заказа не менее 0,01 юаня
//      return (int) max(0.01, $orderAmount - $this->value);
      foreach($items as $item) {

        // Проверка что купон делает скидку на скидочные товары и товар со скидкой
        if ($item['productSku']['product']['on_sale'] && !$this->disabled_other_sales) {
          $price += max(100 , (int) $item['productSku']['product']['price_sale'] * (int) $item['amount'] - $this->value);
        } else if($item['productSku']['product']['on_sale'] && $this->disabled_other_sales) {
          $price += max(100 , (int) $item['productSku']['product']['price_sale'] * (int) $item['amount']);
        } else {
          $price += max(100 , (int) $item['productSku']['product']['price'] * (int) $item['amount'] - $this->value);
        }
      }
      return (int) $price;
    }
  }

  public function changeUsed($increase = true): int
  {
    // Передайте в true, чтобы увеличить использование, иначе уменьшите использование
    if ($increase) {
      // Аналогично проверке инвентаря SKU, здесь необходимо проверить, превысило ли текущее использование общее количество
      return $this->newQuery()->where('id', $this->id)->where('used', '<', $this->total)->increment('used');
    } else {
      return $this->decrement('used');
    }
  }

  public static function findAvailableCode ($length = 16): string
  {
    do {
      // Создать случайную строку указанной длины и преобразовать ее в верхний регистр
      $code = strtoupper(Str::random($length));
      // Продолжить цикл, если сгенерированный код уже существует
    } while (self::query()->where('code', $code)->exists());
    return $code;
  }

  public function productsEnabled (): BelongsToManyAlias
  {
    return $this->belongsToMany('App\Models\Product', 'coupons_products', 'coupon_id', 'product_id');
  }

  public function brandsEnabled (): BelongsToManyAlias
  {
    return $this->belongsToMany('App\Models\Brand', 'coupons_brands', 'coupon_id', 'brand_id');
  }

  public function categoriesEnabled (): BelongsToManyAlias
  {
    return $this->belongsToMany('App\Models\Category', 'coupons_categories', 'coupon_id', 'category_id');
  }

   public function productsDisabled (): BelongsToManyAlias
   {
    return $this->belongsToMany('App\Models\Product', 'disabled_coupons_products', 'coupon_id', 'product_id');
  }

  public function brandsDisabled (): BelongsToManyAlias
  {
    return $this->belongsToMany('App\Models\Brand', 'disabled_coupons_brands', 'coupon_id', 'brand_id');
  }

  public function categoriesDisabled()
  {
    return $this->belongsToMany('App\Models\Category', 'disabled_coupons_categories', 'coupon_id', 'category_id');
  }
}
