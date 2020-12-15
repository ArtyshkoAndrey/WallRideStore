<?php

namespace App\Jobs;

use App\Models\Order;
use App\Notifications\OrderNotPayNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessOrderMailer implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $order;

  /**
   * Create a new job instance.
   *
   * @param Order $order
   * @param Carbon $delay
   */
  public function __construct(Order $order, Carbon $delay)
  {
    $this->order = $order;
    $this->delay($delay);
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    if (!isset($this->order->paid_at)) {
      $this->order->user->notify(new OrderNotPayNotification($this->order));
    }
  }
}
