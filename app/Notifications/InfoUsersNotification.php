<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class InfoUsersNotification extends Notification {
  use Queueable;
  public $data;
  public $user;

  /**
   * Create a new notification instance.
   *
   * @param $data
   * @param $user
   */
  public function __construct($data, User $user)
  {
    $this->data = $data;
    $this->user = $user;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable): array
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return MailMessage
   */
  public function toMail($notifiable): MailMessage
  {
    $view_file = 'emails.info_text';
    $view = View::make($view_file, ['data' => $this->data]);

    $view =  new HtmlString(with(new CssToInlineStyles)->convert($view));

    return (new MailMessage)
      ->subject($this->data['header'] )
      ->view('emails.info', ['text' => $view, 'data' => $this->data, 'user' => $this->user]);
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toArray($notifiable): array
  {
    return [
      //
    ];
  }
}
