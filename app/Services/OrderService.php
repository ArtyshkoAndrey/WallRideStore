<?php

namespace App\Services;

use App\Models\City;
use App\Models\Country;
use App\Models\Product;
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
    public function store(User $user, $address, $items, $payment_method, $express_company, $cost_transfer, CouponCode $coupon = null)
    {
        // 如果传入了优惠券，则先检查是否可用
        if ($coupon) {
            $coupon->checkAvailable($user);
        }
        // 开启一个数据库事务
        $order = \DB::transaction(function () use ($user, $address, $items, $coupon, $payment_method, $express_company, $cost_transfer) {

            $order   = new Order([
              'address'      => [
                  'address'       => ''.Country::find($address['country'])->name.','.City::find($address['city'])->name.','. $address['street'],
                  'contact_name'  => $address['contact_name'],
                  'contact_phone' => $address['phone'],
              ],
              'total_amount' => 0,
              'id_express_company' => $express_company,
              'payment_method' => $payment_method,
              'ship_price' => $cost_transfer
            ]);
            $order->user()->associate($user);
            $order->save();

            $totalAmount = 0;
            $ids = [];
            foreach ($items as $data) {
              array_push($ids, $data['productSku']['id']);
            }
            $productsSku = Product::getProducts($ids);
            $priceAmount = 0;
            foreach ($productsSku as $k => $productSku) {
              $priceAmount += $productSku->product->on_sale ? $productSku->product->price_sale : $productSku->product->price;
            }
            foreach ($items as $data) {
              $sku = ProductSku::find($data['productSku']['id']);
              $item = $order->items()->make([
                'amount' => $data['amount'],
                'price' => $sku->product->on_sale ? $sku->product->price_sale : $sku->product->price,
              ]);
              $item->product()->associate($sku->product_id);
              if (isset($sku->skus->title)) {
                $item->product_sku = $sku->skus->title;
              } else {
                $item->product_sku = 'One Size';
              }
                $item->save();
                if ($sku->decreaseStock($data['amount']) <= 0) {
                    throw new InvalidRequestException('Товар распродан');
                }
            }
            if ($coupon) {
                $coupon->checkAvailable($user, $priceAmount);
                $totalAmount = $coupon->getAdjustedPrice($priceAmount, $items);
//                dd($totalAmount);
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
