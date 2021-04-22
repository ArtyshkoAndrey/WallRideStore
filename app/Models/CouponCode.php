<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use App\Exceptions\CouponCodeUnavailableException;

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
 * @property Carbon $not_before
 * @property Carbon $not_after
 * @property bool $enabled
 * @property bool $notification
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $description
 * @method static Builder|CouponCode newModelQuery()
 * @method static Builder|CouponCode newQuery()
 * @method static Builder|CouponCode query()
 * @method static Builder|CouponCode whereCode($value)
 * @method static Builder|CouponCode whereCreatedAt($value)
 * @method static Builder|CouponCode whereDisabledOtherSales($value)
 * @method static Builder|CouponCode whereEnabled($value)
 * @method static Builder|CouponCode whereId($value)
 * @method static Builder|CouponCode whereMaxAmount($value)
 * @method static Builder|CouponCode whereMinAmount($value)
 * @method static Builder|CouponCode whereNotAfter($value)
 * @method static Builder|CouponCode whereNotBefore($value)
 * @method static Builder|CouponCode whereNotification($value)
 * @method static Builder|CouponCode whereTotal($value)
 * @method static Builder|CouponCode whereType($value)
 * @method static Builder|CouponCode whereUpdatedAt($value)
 * @method static Builder|CouponCode whereUsed($value)
 * @method static Builder|CouponCode whereValue($value)
 * @mixin Eloquent
 * @property-read Collection|Brand[] $brandsDisabled
 * @property-read int|null $brands_disabled_count
 * @property-read Collection|Brand[] $brandsEnabled
 * @property-read int|null $brands_enabled_count
 * @property-read Collection|Category[] $categoriesDisabled
 * @property-read int|null $categories_disabled_count
 * @property-read Collection|Category[] $categoriesEnabled
 * @property-read int|null $categories_enabled_count
 * @property-read Collection|Product[] $productsDisabled
 * @property-read int|null $products_disabled_count
 * @property-read Collection|Product[] $productsEnabled
 * @property-read int|null $products_enabled_count
 * @property bool $random
 * @method static Builder|CouponCode whereRandom($value)
 */
class CouponCode extends Model
{
  use HasFactory;

  /**
   * Columns
   *
   * @var string[]
   */
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
    'notification',
    'random'
  ];

  /**
   * Type Columns
   *
   * @var string[]
   */
  protected $casts = [
    'enabled'               => 'boolean',
    'disabled_other_sales'  => 'boolean',
    'notification'          => 'boolean',
    'random'                => 'boolean',
  ];

  /**
   * Fixed discount
   *
   * @var string
   */
  const TYPE_FIXED   = 'fixed';

  /**
   * Percent discount
   *
   * @var string
   */
  const TYPE_PERCENT = 'percent';

  /**
   * A list of the types of discounts
   *
   * @var array
   */
  const TYPE_MAP = [
    self::TYPE_FIXED,
    self::TYPE_PERCENT
  ];

  /**
   * List of types of discounts in translation
   *
   * @var array|string[]
   */
  public static array $typeMap = [
    self::TYPE_FIXED   => 'Фиксированная сумма',
    self::TYPE_PERCENT => 'Процентная',
  ];

  /**
   * Columns Date
   *
   * @var string[]
   */
  protected $dates = [
    'not_before',
    'not_after'
  ];

  /**
   * Set unction in property
   *
   * @var string[]
   */
  protected $appends = [
    'description'
  ];

  /**
   * Promo code description, discount type and quantity
   *
   * @return string
   */
  public function getDescriptionAttribute (): string
  {
    $str = '';

    if ($this->min_amount > 0) {
      $str = 'От ' . str_replace('.00', '', $this->min_amount) . ' тг. ';
    }
    if ($this->type === self::TYPE_PERCENT) {
      return $str . 'Скидка ' . str_replace('.00', '', $this->value) . '%';
    }

    return $str . 'до ' . str_replace('.00', '', $this->value) . ' тг. скидка';
  }

  /**
   * Basic verification of the promo code by properties
   *
   * @param int|null $price
   * @throws CouponCodeUnavailableException
   */
  public function checkAvailable (int $price = null): void
  {
    if (!$this->enabled) {
      throw new CouponCodeUnavailableException('Купон не существует');
    }

    if (($this->total - $this->used) <= 0) {
      throw new CouponCodeUnavailableException('Все купоны были истрачены');
    }

    if ($this->not_before && $this->not_before->gt(Carbon::now())) {
      throw new CouponCodeUnavailableException('Купон еще не доступен');
    }

    if ($this->not_after && $this->not_after->lt(Carbon::now())) {
      throw new CouponCodeUnavailableException('Срок действия этого купона истек');
    }

    if (!is_null($price) && $price < $this->min_amount) {
      throw new CouponCodeUnavailableException('Сумма заказа не соответствует минимальной сумме купона');
    }
  }

  /**
   * Order where use coupon
   *
   */
  public function order (): \Illuminate\Database\Eloquent\Relations\HasOne
  {
    return $this->hasOne(
      Order::class
    );
  }

  /**
   * Discount on products from the list
   *
   * @return BelongsToMany
   */
  public function productsEnabled (): BelongsToMany
  {
    return $this->belongsToMany(
      Product::class,
      'coupons_products',
      'coupon_id',
      'product_id'
    );
  }

  /**
   * Discount on products in brands from the list
   *
   * @return BelongsToMany
   */
  public function brandsEnabled (): BelongsToMany
  {
    return $this->belongsToMany(
      Brand::class,
      'coupons_brands',
      'coupon_id',
      'brand_id'
    );
  }

  /**
   * Discount on products in categories from the list
   *
   * @return BelongsToMany
   */
  public function categoriesEnabled (): BelongsToMany
  {
    return $this->belongsToMany(
      Category::class,
      'coupons_categories',
      'coupon_id',
      'category_id'
    );
  }

  /**
   * Products without a discount
   *
   * @return BelongsToMany
   */
  public function productsDisabled (): BelongsToMany
  {
    return $this->belongsToMany(
      Product::class,
      'disabled_coupons_products',
      'coupon_id',
      'product_id'
    );
  }

  /**
   * Products without a discount from the list of brands
   *
   * @return BelongsToMany
   */
  public function brandsDisabled (): BelongsToMany
  {
    return $this->belongsToMany(
      Brand::class,
      'disabled_coupons_brands',
      'coupon_id',
      'brand_id'
    );
  }

  /**
   * Products without a discount from the list of categories
   *
   * @return BelongsToMany
   */
  public function categoriesDisabled(): BelongsToMany
  {
    return $this->belongsToMany(
      Category::class,
      'disabled_coupons_categories',
      'coupon_id',
      'category_id'
    );
  }

}
