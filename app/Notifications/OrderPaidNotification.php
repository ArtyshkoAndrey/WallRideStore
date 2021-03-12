<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPaidNotification extends Notification implements ShouldQueue
{
  use Queueable;

  protected Order $order;

  public function __construct(Order $order)
  {
    $this->order = $order;
  }

  public function via($notifiable): array
  {
    return ['mail'];
  }

  public function toMail($notifiable): MailMessage
  {
    return (new MailMessage)
      ->subject('Ваш заказ успешно оплачен')
      ->greeting('Здраствуйте ' . $this->order->user->name)
      ->line($this->order->paid_at->format('d.m.Y H:i') . ' был оплачен ваш заказ по номеру ' . $this->order->no)
      ->action('Просмотреть статус заказа', route('order.index'))
      ->success();
  }
}
