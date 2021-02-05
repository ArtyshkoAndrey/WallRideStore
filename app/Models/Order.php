<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'no',
    'address',
    'price',
    'ship_price',
    'paid_at',
    'payment_method',
    'ship_status',
    'ship_data',
    'sale',
    'transfer'
  ];

  protected $casts = [
    'address' => 'object',
    'ship_data' => 'object',
    'paid_at' => 'datetime'
  ];

  const SHIP_STATUS_PENDING   = 'pending';
  const SHIP_STATUS_PAID      = 'paid';
  const SHIP_STATUS_DELIVERED = 'delivered';
  const SHIP_STATUS_RECEIVED  = 'received';
  const SHIP_STATUS_CANCEL    = 'cancel';

  const SHIP_STATUS_MAP = [
    self::SHIP_STATUS_PENDING,
    self::SHIP_STATUS_PAID,
    self::SHIP_STATUS_DELIVERED,
    self::SHIP_STATUS_RECEIVED,
    self::SHIP_STATUS_CANCEL
  ];

  const PAYMENT_METHODS_CASH = 'cash';
  const PAYMENT_METHODS_CARD = 'cloudPayment';

  const TRANSFER_METHODS_PICKUP = 'pickup';
  const TRANSFER_METHODS_EMS = 'ems';

  public static array $paymentMethodsMap = [
    self::PAYMENT_METHODS_CASH  => 'Оплата в магазине',
    self::PAYMENT_METHODS_CARD  => 'Оплата онлайн',
  ];

  public static array $transferMethodsMap = [
    self::TRANSFER_METHODS_PICKUP => 'Самовывоз',
    self::TRANSFER_METHODS_EMS => 'EMS'
  ];

  public static array $shipStatusMap = [
    self::SHIP_STATUS_PAID      => 'Не оплачен',
    self::SHIP_STATUS_PENDING   => 'В обработке',
    self::SHIP_STATUS_DELIVERED => 'Отправлен',
    self::SHIP_STATUS_RECEIVED  => 'Получен',
    self::SHIP_STATUS_CANCEL    => 'Отменён',
  ];

  /**
   * Перегразка boot. Создание номера заказа
   */
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

  /**
   * Генерация номера заказа
   *
   * @return false|string
   * @throws Exception
   */
  public static function findAvailableNo ()
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

  public function user (): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function items (): HasMany
  {
    return $this->hasMany(OrderItem::class);
  }


  public static function getColorColumn ($status): string
  {
    if ($status === Order::SHIP_STATUS_CANCEL) {
      return 'table-danger';
    } else if ($status === Order::SHIP_STATUS_DELIVERED || $status === Order::SHIP_STATUS_PENDING) {
      return 'table-primary';
    } else if ($status === Order::SHIP_STATUS_RECEIVED) {
      return 'table-success';
    } else {
      return '';
    }
  }
}
