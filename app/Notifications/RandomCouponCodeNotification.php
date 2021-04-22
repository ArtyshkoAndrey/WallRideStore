<?php

namespace App\Notifications;

use App\Models\CouponCode;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class RandomCouponCodeNotification extends Notification
{
  use Queueable;

  protected CouponCode $code;
  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(CouponCode $code)
  {
    $this->code = $code;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param mixed $notifiable
   * @return array
   */
  public function via($notifiable)
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
    return (new MailMessage)
      ->subject('Новый промокод для пользователей')
      ->greeting('Здраствуй Администратор')
      ->line('Система на сегодня сгенерировала новый промогод')
      ->line(new HtmlString('<strong style="text-align: center">' . $this->code->code . '</strong>'))
      ->line('Если имеется модальное окно, то оно автоматически обновиться под новый промокод');
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
