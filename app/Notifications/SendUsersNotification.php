<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class SendUsersNotification extends Notification
{
  use Queueable;

  protected string $image;
  protected string $title;
  protected string $content;
  protected string $email;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(string $image, string $title, string $content, string $email)
  {
    $this->image = $image;
    $this->title = $title;
    $this->content = $content;
    $this->email = $email;
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
    $view_file = 'emails.notification.send-user';
    $view = View::make($view_file, ['content' => $this->content]);

    $view =  new HtmlString(with(new CssToInlineStyles)->convert($view));

    return (new MailMessage)
      ->subject($this->title )
      ->view('emails.notification.info', [
        'text' => $view,
        'title' => $this->title,
        'image' => $this->image,
        'email' => $this->email
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
