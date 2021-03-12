<?php

namespace App\Notifications;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Class CreateOrderNotification
 * @package App\Notifications
 *
 * Уведомление о отмене заказа
 */

class CloseOrderNotification extends Notification implements ShouldQueue
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
    $category = Category::whereDoesntHave('parents')->get();

    return (new MailMessage)
      ->subject('Заказ № ' . $this->order->no . ' успешно отменён')
      ->view('emails.order.canceled', [
        'order' => $this->order,
        'category' => $category
      ]);
  }
}
