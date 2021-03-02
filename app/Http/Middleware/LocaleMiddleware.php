<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Http\Request;

class LocaleMiddleware
{
  /**
   * main language that shouldn't appear in URl
   * @var string
   */
  public static string $mainLanguage = 'ru';

  /**
   * List of available localizations
   * @var array|string[]
   */
  public static array $languages = [
    'en',
    'ru'
  ];

  /**
   * Handle an incoming request.
   * @param Request $request
   * @param Closure $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    $locale = self::getLocale();
    if($locale) App::setLocale($locale);
//  if there is no label - set the main language $mainLanguage
    else App::setLocale(self::$mainLanguage);

//  skip further - pass to the next intermediary
    return $next($request);
  }

  /**
   * Returns the selected language from the cookie
   * @return mixed|null
   */
  public static function getLocale()
  {
    return $_COOKIE['language'] ?? null;
  }
}
