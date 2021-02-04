<?php

namespace App\Http\Middleware;

use Closure;
use App;
use \Illuminate\Http\Request;

class LocaleMiddleware
{
  public static string $mainLanguage = 'ru'; //основной язык, который не должен отображаться в URl

  public static array $languages = ['en', 'ru']; // Указываем, какие языки будем использовать в приложении.

  /**
   * Handle an incoming request.
   *
   * @param Request $request
   * @param Closure $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    $locale = self::getLocale();
//    dd($locale);
    if($locale) App::setLocale($locale);

    //если метки нет - устанавливаем основной язык $mainLanguage
    else App::setLocale(self::$mainLanguage);

    return $next($request); //пропускаем дальше - передаем в следующий посредник
  }

  public static function getLocale()
  {
    return isset($_COOKIE['language']) ? $_COOKIE['language'] : null ;
  }
}
