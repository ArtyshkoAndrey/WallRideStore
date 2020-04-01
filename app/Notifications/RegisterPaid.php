<?php


namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class RegisterPaid extends Notification {
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
      ->subject('Оплачен новый заказ')
      ->greeting('Здраствуйте')
      ->line($this->order->paid_at ? ($this->order->paid_at->format('d.m.Y H:i') . ' был оплачен заказ по номеру ' . $this->order->no) : ($this->order->created_at->format('d.m.Y H:i') . ' был создан заказ по номеру ' . $this->order->no))
      ->line('Заказ оплатил ' . $this->order->user->name . '.')
      ->line('Общая стоимость заказа составляет ' . ($this->order->total_amount + (isset($this->order->ship_price) ? $this->order->ship_price : 0)) . ' тг.')
      ->action('Просмотреть статус заказа', route('admin.store.order.edit', $this->order->id))
      ->success();
  }
}
