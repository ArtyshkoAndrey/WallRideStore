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

class OrderEditNotification extends Notification implements ShouldQueue {
  use Queueable;

  protected $order;
  protected $status;

  public function __construct(Order $order, string $status) {
    $this->order = $order;
    $this->status = $status;
  }

  public function via($notifiable): array
  {
    return ['mail'];
  }

  public function toMail($notifiable): MailMessage
  {

    return (new MailMessage)
      ->subject('Статус заказа № ' . $this->order->no . ' изменён' )
      ->view('emails.order-edit', ['order' => $this->order, 'status' => $this->status]);
  }
}
