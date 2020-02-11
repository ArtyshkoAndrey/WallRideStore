<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Order extends Model
{
  const REFUND_STATUS_PENDING = 'pending';
  const REFUND_STATUS_APPLIED = 'applied';
  const REFUND_STATUS_PROCESSING = 'processing';
  const REFUND_STATUS_SUCCESS = 'success';
  const REFUND_STATUS_FAILED = 'failed';

  const SHIP_STATUS_PENDING = 'pending';
  const SHIP_STATUS_DELIVERED = 'delivered';
  const SHIP_STATUS_RECEIVED = 'received';

  const PAYMENT_METHODS_CASH = 'cash';
  const PAYMENT_METHODS_CARD = 'card';

  public static $paymentMethodsMap = [
    self::PAYMENT_METHODS_CASH    => 'Наличными',
    self::PAYMENT_METHODS_CARD    => 'Картой',
  ];

  const EXPRESS_METHODS_ASE = 'ase';
  const EXPRESS_METHODS_EMS = 'ems';
  const EXPRESS_METHODS_PICKUP = 'pickup';

  public static $expressMethodsMap = [
    self::EXPRESS_METHODS_ASE    => 'Asia sky Expreess',
    self::EXPRESS_METHODS_EMS    => 'EMS',
    self::EXPRESS_METHODS_PICKUP => 'Самовывоз'
  ];

  public static $refundStatusMap = [
    self::REFUND_STATUS_PENDING    => 'Не возвращается',
    self::REFUND_STATUS_APPLIED    => 'Требуется возврат',
    self::REFUND_STATUS_PROCESSING => 'Возврат',
    self::REFUND_STATUS_SUCCESS    => 'Возврат успешно',
    self::REFUND_STATUS_FAILED     => 'Возврат не удался',
  ];

  public static $shipStatusMap = [
    self::SHIP_STATUS_PENDING   => 'В обработке',
    self::SHIP_STATUS_DELIVERED => 'Отправлен',
    self::SHIP_STATUS_RECEIVED  => 'Получен',
  ];

  protected $fillable = [
    'no',
    'address',
    'total_amount',
    'remark',
    'paid_at',
    'payment_method',
    'express_company',
    'payment_no',
    'refund_status',
    'refund_no',
    'closed',
    'reviewed',
    'ship_status',
    'ship_data',
    'extra',
  ];

  protected $casts = [
      'closed'    => 'boolean',
      'reviewed'  => 'boolean',
      'address'   => 'json',
      'ship_data' => 'json',
      'extra'     => 'json',
  ];

  protected $dates = [
      'paid_at',
  ];

  protected static function boot()
  {
      parent::boot();
      // Слушайте события создания модели и запускайте ее перед записью в базу данных.
      static::creating(function ($model) {
          // Если в модели нет поля пусто
          if (!$model->no) {
              // Вызовите findAvailableNo для создания серийного номера заказа
              $model->no = static::findAvailableNo();
              // Если генерация не удалась, завершите создание заказа
              if (!$model->no) {
                  return false;
              }
          }
      });
  }

  public function user()
  {
      return $this->belongsTo(User::class);
  }

  public function items()
  {
      return $this->hasMany(OrderItem::class);
  }

  public function couponCode()
  {
      return $this->belongsTo(CouponCode::class);
  }

  public static function findAvailableNo()
  {
      // Префикс серийного номера заказа
      $prefix = date('YmdHis');
      for ($i = 0; $i < 10; $i++) {
          // Случайно сгенерированный 6-значный номер
          $no = $prefix.str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
          // Определите, существует ли он уже
          if (!static::query()->where('no', $no)->exists()) {
              return $no;
          }
      }
      \Log::warning('find order no failed');

      return false;
  }

  public static function getAvailableRefundNo()
  {
      do {
          // Класс Uuid может быть использован для генерации уникальных строк с высокой вероятностью
          $no = Uuid::uuid4()->getHex();
          // Чтобы избежать повторения, мы запрашиваем базу данных после генерации, чтобы узнать, существует ли такой же номер заказа на возврат.
      } while (self::query()->where('refund_no', $no)->exists());

      return $no;
  }
}
