<?php

namespace App\Admin\Controllers;

use App\Exceptions\InternalException;
use App\Exceptions\InvalidRequestException;
use App\Http\Requests\Admin\HandleRefundRequest;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('Заказы')
            ->body($this->grid());
    }

    public function show(Order $order, Content $content)
    {
        return $content
            ->header('Просмотр заказа')
            // Метод body может принимать представления Laravel в качестве параметров
            ->body(view('admin.orders.show', ['order' => $order]));
    }

    protected function grid()
    {
        $grid = new Grid(new Order);

        // Показывать только оплаченные заказы и сортировать по времени оплаты в обратном порядке по умолчанию
        $grid->model()->whereNotNull('paid_at')->orderBy('paid_at', 'desc');

        $grid->no('Номер');
        // Использовать метод столбца при отображении связанных полей
        $grid->column('user.name', 'Покупатель');
        $grid->total_amount('Общая сумма')->sortable();
        $grid->paid_at('Время оплаты')->sortable();
        $grid->ship_status('Статус отправки')->display(function($value) {
            return Order::$shipStatusMap[$value];
        });
        $grid->refund_status('Статус возврата')->display(function($value) {
            return Order::$refundStatusMap[$value];
        });
        // Отключаем кнопку создания, нет необходимости создавать заказ в фоновом режиме
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            // Отключить кнопки удаления и редактирования
            $actions->disableDelete();
            $actions->disableEdit();
        });
        $grid->tools(function ($tools) {
            // Отключить кнопку массового удаления
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        return $grid;
    }

    public function ship(Order $order, Request $request)
    {
        // Определите, был ли оплачен текущий заказ
        if (!$order->paid_at) {
            throw new InvalidRequestException('Заказ не выполнен');
        }
        // Определить, не доставлен ли текущий статус доставки заказа
        if ($order->ship_status !== Order::SHIP_STATUS_PENDING) {
            throw new InvalidRequestException('Заказ был отправлен');
        }
        // Метод проверки Laravel 5.5 может возвращать проверенные значения
        $data = $this->validate($request, [
            'express_company' => ['required'],
            'express_no'      => ['required'],
        ], [], [
            'express_company' => 'Логистическая компания',
            'express_no'      => 'Логистический номер',
        ]);
        // Измените статус доставки заказа на отправленный и сохраните логистическую информацию
        $order->update([
            'ship_status' => Order::SHIP_STATUS_DELIVERED,
            // Мы указали, что ship_data - это массив в свойстве $ casts модели Order
            // Так что здесь вы можете напрямую передать массив
            'ship_data'   => $data,
        ]);

        // Вернуться на предыдущую страницу
        return redirect()->back();
    }

    public function handleRefund(Order $order, HandleRefundRequest $request)
    {
        // Определить, если статус заказа правильный
        if ($order->refund_status !== Order::REFUND_STATUS_APPLIED) {
            throw new InvalidRequestException('Неверный статус заказа');
        }
        // Стоит ли соглашаться на возврат
        if ($request->input('agree')) {
            // Явный отказ от возврата
            $extra = $order->extra ?: [];
            unset($extra['refund_disagree_reason']);
            $order->update([
                'extra' => $extra,
            ]);
            // Вызывая логику возврата
            $this->_refundOrder($order);
        } else {
            // Укажите причину отказа в дополнительном поле заказа
            $extra = $order->extra ?: [];
            $extra['refund_disagree_reason'] = $request->input('reason');
            // Изменить статус возврата заказа на невозвратный
            $order->update([
                'refund_status' => Order::REFUND_STATUS_PENDING,
                'extra'         => $extra,
            ]);
        }

        return $order;
    }

    protected function _refundOrder(Order $order)
    {
        // Определите способ оплаты для этого заказа
        switch ($order->payment_method) {
            case 'wechat':
                // 生成退款订单号
                $refundNo = Order::getAvailableRefundNo();
                app('wechat_pay')->refund([
                    'out_trade_no' => $order->no, // 之前的订单流水号
                    'total_fee' => $order->total_amount * 100, //原订单金额，单位分
                    'refund_fee' => $order->total_amount * 100, // 要退款的订单金额，单位分
                    'out_refund_no' => $refundNo, // 退款订单号
                    // 微信支付的退款结果并不是实时返回的，而是通过退款回调来通知，因此这里需要配上退款回调接口地址
                    'notify_url' => route('payment.wechat.refund_notify'),
                ]);
                // 将订单状态改成退款中
                $order->update([
                    'refund_no' => $refundNo,
                    'refund_status' => Order::REFUND_STATUS_PROCESSING,
                ]);
                break;
            case 'alipay':
                // 用我们刚刚写的方法来生成一个退款订单号
                $refundNo = Order::getAvailableRefundNo();
                // 调用支付宝支付实例的 refund 方法
                $ret = app('alipay')->refund([
                    'out_trade_no' => $order->no, // 之前的订单流水号
                    'refund_amount' => $order->total_amount, // 退款金额，单位元
                    'out_request_no' => $refundNo, // 退款订单号
                ]);
                // 根据支付宝的文档，如果返回值里有 sub_code 字段说明退款失败
                if ($ret->sub_code) {
                    // 将退款失败的保存存入 extra 字段
                    $extra = $order->extra;
                    $extra['refund_failed_code'] = $ret->sub_code;
                    // 将订单的退款状态标记为退款失败
                    $order->update([
                        'refund_no' => $refundNo,
                        'refund_status' => Order::REFUND_STATUS_FAILED,
                        'extra' => $extra,
                    ]);
                } else {
                    // 将订单的退款状态标记为退款成功并保存退款订单号
                    $order->update([
                        'refund_no' => $refundNo,
                        'refund_status' => Order::REFUND_STATUS_SUCCESS,
                    ]);
                }
                break;
            default:
                // В принципе невозможно, это просто для надежности кода
                throw new InternalException('Неизвестный способ оплаты заказа：'.$order->payment_method);
                break;
        }
    }
}
