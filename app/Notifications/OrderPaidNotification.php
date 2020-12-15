<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class OrderPaidNotification extends Notification implements ShouldQueue {
  use Queueable;

  protected $order;

  public function __construct(Order $order) {
    $this->order = $order;
  }

  public function via($notifiable): array
  {
    return ['mail'];
  }

  public function toMail($notifiable): MailMessage
  {

    return (new MailMessage)
      ->subject('Оплата заказа № ' . $this->order->no )
      ->view('emails.order-pay', ['order' => $this->order]);
  }
}
