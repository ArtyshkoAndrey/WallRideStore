<?php

namespace App\Jobs;

use App\Models\CouponCode;
use App\Models\User;
use App\Notifications\RandomCouponCodeNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

// Генерация нового промокода
class RandomCouponCode implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public function __construct()
  {

  }

  /**
   * @throws Exception
   * @return void
   */
  public function handle(): void
  {
//    Делает не активными промокоды у которых есть заказы

//    Удаляет рандомный ранее промокод в которых нету заказов
    $code = CouponCode::whereRandom(true)->first();
    if (!$code) {
      $code = new CouponCode();
    }
    $code->code = $this->randomCode();
    $code->type = CouponCode::TYPE_PERCENT;
    $code->value = 5;
    $code->total = 900;
    $code->used = 0;
    $code->min_amount = 0;
    $code->max_amount = 90000;
    $code->not_before = Carbon::now()->subDay();
    $code->not_after = Carbon::now()->addDays(2);
    $code->enabled = true;
    $code->random = true;
    $code->notification = false;
    $code->save();

    $users = User::whereIsAdmin(true)->get();
    foreach ($users as $user) {
      $user->notify(new RandomCouponCodeNotification($code));
    }
  }

  /**
   * @throws Exception
   */
  public function randomCode (): string
  {
    $str = Str::random(10);
    if (CouponCode::whereCode($str)->count() > 0) {
      return $this->randomCode();
    }
    return $str;
  }
}
