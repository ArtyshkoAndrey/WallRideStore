<?php

namespace App\Jobs;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

// Бесконечный слушатель, который убирает рас в интервал просмотры с мобадлок для зарегестрированых пользователей
class ListenerStockUser implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $stock;
  protected $delayView;

  public function __construct(Stock $stock, int $delay)
  {
    $this->stock = $stock;
    $this->delayView = $delay;
    $this->delay(now()->addSeconds($delay));
  }

  public function handle()
  {
    if (Stock::find($this->stock->id)) {
      $users = User::whereNotification(false)->get();

      foreach ($users as $user) {
        if ($user->checkedStockView($this->stock)) {
          Log::debug($user->checkedStockView($this->stock));
          $user->changeStockView($this->stock, 0);
        }
      }

      ListenerStockUser::dispatch($this->stock, $this->delayView);
    }
  }
}
