<?php

use App\Models\CouponCode;
use App\Models\Order;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    // Случайно принять пользователя
    $user = User::query()->inRandomOrder()->first();
    // Случайно взять адрес этого пользователя
    $address = $user->addresses()->inRandomOrder()->first();
    // 10% вероятности отметить заказ как возврат
    $refund = random_int(0, 10) < 1;
    // Случайно сгенерированный статус доставки
    $ship = $faker->randomElement(array_keys(Order::$shipStatusMap));
    // купон
    $coupon = null;
    // 30% вероятность того, что заказ использовал купон
    if (random_int(0, 10) < 3) {
        // Чтобы избежать логических ошибок, мы выбираем только купоны, которые не имеют минимального лимита суммы
        $coupon = CouponCode::query()->where('min_amount', 0)->inRandomOrder()->first();
        // Увеличить использование купонов
        $coupon->changeUsed();
    }

    return [
        'address'        => [
            'address'       => $address->full_address,
            'zip'           => $address->zip,
            'contact_name'  => $address->contact_name,
            'contact_phone' => $address->contact_phone,
        ],
        'total_amount'   => 0,
        'remark'         => $faker->sentence,
        'paid_at'        => $faker->dateTimeBetween('-30 days'), // 30 дней назад в любое время
        'payment_method' => $faker->randomElement(['wechat', 'alipay']),
        'payment_no'     => $faker->uuid,
        'refund_status'  => $refund ? Order::REFUND_STATUS_SUCCESS : Order::REFUND_STATUS_PENDING,
        'refund_no'      => $refund ? Order::getAvailableRefundNo() : null,
        'closed'         => false,
        'reviewed'       => random_int(0, 10) > 2,
        'ship_status'    => $ship,
        'ship_data'      => $ship === Order::SHIP_STATUS_PENDING ? null : [
            'express_company' => $faker->company,
            'express_no'      => $faker->uuid,
        ],
        'extra'          => $refund ? ['refund_reason' => $faker->sentence] : [],
        'user_id'        => $user->id,
        'coupon_code_id' => $coupon ? $coupon->id : null,
    ];
});
