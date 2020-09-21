<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class OrderCancledNotification extends Notification implements ShouldQueue {
  use Queueable;

  protected $order;

  public function __construct(Order $order) {
    $this->order = $order;
  }

  public function via($notifiable) {
    return ['mail'];
  }

  public function toMail($notifiable) {
    return (new MailMessage)
      ->subject('Ваш заказ был отменён за неуплату в течении 3 часов')
      ->greeting('Здраствуйте ' . $this->order->user->name)
      ->line(Carbon::now()->format('d.m.Y H:i') . ' был отменён ваш заказ по номеру ' . $this->order->no)
      ->action('Просмотреть статус заказа', route('orders.index'))
      ->success();
  }
}
