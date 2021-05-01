<?php

namespace App\Notifications;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminPaidOrderNotification extends Notification
{
  use Queueable;

  protected Order $order;

  /**
   * Create a new notification instance.
   *
   * @param Order $order
   * @return void
   */
  public function __construct(Order $order)
  {
    $this->order = $order;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param mixed $notifiable
   * @return array
   */
  public function via($notifiable): array
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param mixed $notifiable
   * @return MailMessage
   */
  public function toMail($notifiable): MailMessage
  {
    $category = Category::whereDoesntHave('parents')->get();

    return (new MailMessage)
      ->subject('Заказ № ' . $this->order->no . ' успешно оплачен')
      ->view('emails.order.admin', [
        'order' => $this->order,
        'category' => $category
      ]);
  }

  /**
   * Get the array representation of the notification.
   *
   * @param mixed $notifiable
   * @return array
   */
  public function toArray($notifiable): array
  {
    return [
      //
    ];
  }
}
