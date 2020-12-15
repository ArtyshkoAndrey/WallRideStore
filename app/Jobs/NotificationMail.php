<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\InfoUsersNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotificationMail implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $data;
  protected $user;

  public function __construct(array $data, User $user)
  {
    $this->data = $data;
    $this->user = $user;
  }

  public function handle()
  {
    $this->user->notify(new InfoUsersNotification($this->data, $this->user));
  }
}
