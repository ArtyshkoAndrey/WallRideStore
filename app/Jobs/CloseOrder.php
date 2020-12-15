<?php

namespace App\Jobs;

use App\Notifications\OrderCancledNotification;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Order;

// Работа когда нужно закрыть заказ, т.е. отмена
class CloseOrder implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $order;

  public function __construct(Order $order, Carbon $delay)
  {
      $this->order = $order;
      $this->delay($delay);
  }

  public function handle()
  {
    if (!isset($this->order->paid_at) || $this->order->ship_status !== Order::SHIP_STATUS_CANCEL) {
      (new OrderService)->cancled($this->order);
      $this->order->user->notify(new OrderCancledNotification($this->order));
    }
  }
}
