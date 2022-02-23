<?php

namespace App\Models;

use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Log;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $no
 * @property int $user_id
 * @property object $address
 * @property string $price
 * @property string $ship_price
 * @property Carbon|null $paid_at
 * @property string $payment_method
 * @property string $ship_status
 * @property object|null $ship_data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $coupon_code_id
 * @property string $sale
 * @property string $transfer
 * @property-read Collection|OrderItem[] $items
 * @property-read int|null $items_count
 * @property-read User $user
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereAddress($value)
 * @method static Builder|Order whereCouponCodeId($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereNo($value)
 * @method static Builder|Order wherePaidAt($value)
 * @method static Builder|Order wherePaymentMethod($value)
 * @method static Builder|Order wherePrice($value)
 * @method static Builder|Order whereSale($value)
 * @method static Builder|Order whereShipData($value)
 * @method static Builder|Order whereShipPrice($value)
 * @method static Builder|Order whereShipStatus($value)
 * @method static Builder|Order whereTransfer($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order whereUserId($value)
 * @mixin Eloquent
 * @property-read CouponCode|null $couponCode
 */
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

  /**
   * Type Columns
   *
   * @var string[]
   */
  protected $casts = [
    'address'   => 'object',
    'ship_data' => 'object',
    'paid_at'   => 'datetime'
  ];

  /**
   * The order status from pending
   *
   * @var string
   */
  const SHIP_STATUS_PENDING = 'pending';

  /**
   * The status of the order is not paid
   *
   * @var string
   */
  const SHIP_STATUS_PAID = 'paid';

  /**
   * The order status is Delivered
   *
   * @var string
   */
  const SHIP_STATUS_DELIVERED = 'delivered';

  /**
   * The order status is Ready for delivery
   *
   * @var string
   */
  const SHIP_STATUS_READY_DELIVERY = 'ready_delivery';

  /**
   * Order Status Received
   *
   * @var string
   */
  const SHIP_STATUS_RECEIVED = 'received';

  /**
   * The order status is Cancelled
   *
   * @var string
   */
  const SHIP_STATUS_CANCEL = 'cancel';

  /**
   * List of order statuses
   *
   * @var array
   */
  const SHIP_STATUS_MAP = [
    self::SHIP_STATUS_PENDING,
    self::SHIP_STATUS_PAID,
    self::SHIP_STATUS_DELIVERED,
    self::SHIP_STATUS_READY_DELIVERY,
    self::SHIP_STATUS_RECEIVED,
    self::SHIP_STATUS_CANCEL
  ];

  /**
   * Cash payment method
   *
   * @var string
   */
  const PAYMENT_METHODS_CASH = 'cash';

  /**
   * Payment method via online payment
   *
   * @var string
   */
  const PAYMENT_METHODS_CARD = 'cloudPayment';

  /**
   * Delivery method pickup
   *
   * @var string
   */
  const TRANSFER_METHODS_PICKUP = 'pickup';

  /**
   * Shipping method via EMS
   *
   * @var string
   */
  const TRANSFER_METHODS_EMS = 'ems';

  /**
   * List of payment methods with a translator for people
   *
   * @var array|string[]
   */
  public static array $paymentMethodsMap = [
    self::PAYMENT_METHODS_CASH  => 'Оплата в магазине',
    self::PAYMENT_METHODS_CARD  => 'Оплата онлайн',
  ];

  /**
   * List of delivery methods with a translator for people
   *
   * @var array|string[]
   */
  public static array $transferMethodsMap = [
    self::TRANSFER_METHODS_PICKUP => 'Самовывоз',
    self::TRANSFER_METHODS_EMS    => 'EMS'
  ];

  /**
   * List of order statuses with a translator for people
   *
   * @var array|string[]
   */
  public static array $shipStatusMap = [
    self::SHIP_STATUS_PAID            => 'Не оплачен',
    self::SHIP_STATUS_PENDING         => 'В обработке',
    self::SHIP_STATUS_DELIVERED       => 'Отправлен',
    self::SHIP_STATUS_READY_DELIVERY  => 'Готов к выдаче',
    self::SHIP_STATUS_RECEIVED        => 'Получен',
    self::SHIP_STATUS_CANCEL          => 'Отменён',
  ];

  /**
   * Перегразка boot. Создание номера заказа
   */
  protected static function boot()
  {
    parent::boot();
    // Listen to the model creation events and run it before writing it to the database.
    static::creating(function ($model) {
      // If the model does not have the field empty
      if (!$model->no) {
        // Find Available No call to generate the serial numbers of the order
        $model->no = static::findAvailableNo();
        // If the generation failed, complete the order creation
        if (!$model->no) {
          return false;
        }
      }

      return true;
    });
  }

  /**
   * Generating an order number
   *
   * @return false|string
   * @throws Exception
   */
  public static function findAvailableNo ()
  {
    // Order Serial number prefix
    $prefix = date('YmdHis');

    for ($i = 0; $i < 10; $i++) {
      // Randomly generated 6-digit number
      $no = $prefix.str_pad(
        random_int(0, 999999),
        6,
        '0',
        STR_PAD_LEFT
        );
      // Determine if it already exists
      if (!static::query()->where('no', $no)->exists()) {
        return $no;
      }
    }
    Log::warning('find order no failed');

    return false;
  }

  /**
   * The user of the order
   *
   * @return BelongsTo
   */
  public function user (): BelongsTo
  {
    return $this->belongsTo(
      User::class
    );
  }

  /**
   * Product ordered
   *
   * @return HasMany
   */
  public function items (): HasMany
  {
    return $this->hasMany(
      OrderItem::class
    );
  }


  /**
   * Determining the color of the salt shaker based on the order status
   *
   * @param $status
   * @return string
   */
  public static function getColorColumn ($status): string
  {
    if ($status === Order::SHIP_STATUS_CANCEL) {
      return 'table-danger';
    }
    else if ($status === Order::SHIP_STATUS_DELIVERED || $status === Order::SHIP_STATUS_PENDING || Order::SHIP_STATUS_READY_DELIVERY) {
      return 'table-primary';
    }
    else if ($status === Order::SHIP_STATUS_RECEIVED) {
      return 'table-success';
    }

    return '';
  }

  /**
   * Order promo code
   *
   * @return BelongsTo
   */
  public function couponCode (): BelongsTo
  {
    return $this->belongsTo(
      CouponCode::class
    );
  }

  public function company ()
  {
    if ($this->transfer === self::TRANSFER_METHODS_EMS) {
      return (object)['track_url' => 'https://post.kz/services/postal/'];
    }
    return ExpressCompany::whereName($this->transfer)->first();
  }
}
