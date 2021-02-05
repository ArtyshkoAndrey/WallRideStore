<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
