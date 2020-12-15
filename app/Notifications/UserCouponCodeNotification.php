<?php


namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCouponCodeNotification extends Notification{
  use Queueable;

  protected $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function via($notifiable): array
  {
    return ['mail'];
  }

  public function toMail($notifiable): MailMessage
  {
    return (new MailMessage)
      ->subject('Вы успешно подписались на новостные рассылки wallridestore.com')
      ->view('emails.user-coupon-code', ['user' => $this->user]);
  }

}
