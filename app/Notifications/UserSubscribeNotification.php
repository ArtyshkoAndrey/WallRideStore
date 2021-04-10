<?php

namespace App\Notifications;

use App\Models\Category;
use App\Models\CouponCode;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Class UserSubscribeNotification
 * Уведомление когда пользователь первый раз подписывается на рассылку
 * @package App\Notifications
 */
class UserSubscribeNotification extends Notification
{
  use Queueable;
//  protected CouponCode $coupon;
  protected User $user;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(User $user)
  {
//    $this->coupon = $coupon;
    $this->user = $user;
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
      ->subject('Вы успешно подписались на новостную рассылку на сайте WallrideStore.com')
      ->view('emails.notification.subscribe', [
        'user' => $this->user,
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
