<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CouponCode
 *
 * @property int $id
 * @property string $code
 * @property string $type
 * @property string $value
 * @property int $total
 * @property int $used
 * @property string $min_amount
 * @property string $max_amount
 * @property bool $disabled_other_sales
 * @property \Illuminate\Support\Carbon $not_before
 * @property \Illuminate\Support\Carbon $not_after
 * @property bool $enabled
 * @property bool $notification
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $description
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereDisabledOtherSales($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereMaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereMinAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereNotAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereNotBefore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereNotification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponCode whereValue($value)
 * @mixin \Eloquent
 */
class CouponCode extends Model
{
  use HasFactory;

  protected $fillable = [
    'code',
    'type',
    'value',
    'total',
    'used',
    'min_amount',
    'max_amount',
    'disabled_other_sales',
    'not_before',
    'not_after',
    'enabled',
    'notification'
  ];

  protected $casts = [
    'enabled' => 'boolean',
    'disabled_other_sales' => 'boolean',
    'notification' => 'boolean'
  ];

  // Постоянно определяйте поддерживаемые типы купонов
  const TYPE_FIXED   = 'fixed';
  const TYPE_PERCENT = 'percent';

  const TYPE_MAP = [
    self::TYPE_FIXED,
    self::TYPE_PERCENT
  ];

  public static array $typeMap = [
    self::TYPE_FIXED   => 'Фиксированная сумма',
    self::TYPE_PERCENT => 'Процентная',
  ];
  protected $dates = ['not_before', 'not_after'];

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
}
