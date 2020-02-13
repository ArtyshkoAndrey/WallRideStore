<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserAddress;
use App\Models\Order;
use App\Models\ProductSku;
use App\Exceptions\InvalidRequestException;
use App\Jobs\CloseOrder;
use Carbon\Carbon;
use App\Models\CouponCode;
use App\Exceptions\CouponCodeUnavailableException;

class OrderService
{
    public function store(User $user, $address, $items, $payment_method, $express_company, CouponCode $coupon = null)
    {
        // 如果传入了优惠券，则先检查是否可用
        if ($coupon) {
            $coupon->checkAvailable($user);
        }
        // 开启一个数据库事务
        $order = \DB::transaction(function () use ($user, $address, $items, $coupon, $payment_method, $express_company) {

            $order   = new Order([
              'address'      => [
                  'address'       => "{$address['country']}, {$address['city']}, {$address['street']}",
                  'contact_name'  => $address['contact_name'],
                  'contact_phone' => $address['phone'],
              ],
              'total_amount' => 0,
              'express_company' => $express_company,
              'payment_method' => $payment_method
            ]);
            $order->user()->associate($user);
            $order->save();

            $totalAmount = 0;
            foreach ($items as $data) {
                $sku  = ProductSku::find($data['sku_id']);
                $item = $order->items()->make([
                    'amount' => $data['amount'],
                    'price'  => $sku->price,
                ]);
                $item->product()->associate($sku->product_id);
                $item->productSku()->associate($sku);
                $item->save();
                $totalAmount += $sku->price * $data['amount'];
                // throw new \Exception($sku->);
                // return $sku->decreaseStock($data['amount']);
                // dd($sku->decreaseStock($data['amount']))
                // return $sku->decreaseStock($data['amount']);
                if ($sku->decreaseStock($data['amount']) <= 0) {
                    throw new InvalidRequestException('Товар распродан');
                }
            }
            if ($coupon) {
                $coupon->checkAvailable($user, $totalAmount);
                $totalAmount = $coupon->getAdjustedPrice($totalAmount);
                $order->couponCode()->associate($coupon);
                if ($coupon->changeUsed() <= 0) {
                    throw new CouponCodeUnavailableException('该优惠券已被兑完');
                }
            }
            $order->update(['total_amount' => $totalAmount]);

            $skuIds = collect($items)->pluck('sku_id')->all();
            app(CartService::class)->remove($skuIds);

            return $order;
        });

        // dispatch(new CloseOrder($order, config('app.order_ttl')));

        return $order;
    }
}
