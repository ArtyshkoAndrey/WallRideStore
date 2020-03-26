<?php


namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisterPassword extends Notification{
  use Queueable;

  protected $email;
  protected $password;

  public function __construct($email, $password) {
    $this->email = $email;
    $this->password = $password;
  }

  public function via($notifiable) {
    return ['mail'];
  }

  public function toMail($notifiable) {
    return (new MailMessage)
      ->subject('Новый аккаунт')
      ->greeting('Здраствуйте')
      ->line('Вы успешно зарегестрировались')
      ->line('Ваш логин: ' . $this->email)
      ->line('Ваш пароль: ' . $this->password)
      ->action('Просмотреть новые товары', route('products.all', ['order' => 'new_desc']))
      ->success();
  }
}
