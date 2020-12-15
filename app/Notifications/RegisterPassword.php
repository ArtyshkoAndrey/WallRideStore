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
      ->subject('Ваш аккаунт успешно создан')
      ->view('emails.register', ['email' => $this->email, 'password' => $this->password]);
  }
}
