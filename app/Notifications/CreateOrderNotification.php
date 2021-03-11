<?php

namespace App\Notifications;

use App\Models\Category;
use Cache;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class CreateOrderNotification extends Notification implements ShouldQueue {
  use Queueable;

  protected Order $order;

  public function __construct(Order $order) {
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
      ->subject('Заказ № ' . $this->order->no . ' успешно создан')
      ->view('emails.order', [
        'order' => $this->order,
        'category' => $category
      ]);
  }
}
