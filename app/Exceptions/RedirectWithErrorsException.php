<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RedirectWithErrorsException extends Exception
{
  /**
   * RedirectWithErrorsException constructor.
   * @param $message
   * @param int $code
   */
  public function __construct($message, int $code = 403)
  {
    parent::__construct($message, $code);
  }

  /**
   * @param Request $request
   * @return JsonResponse|RedirectResponse
   */
  public function render(Request $request)
  {

    if ($request->expectsJson()) {
      return response()->json(['message' => $this->message], $this->code);
    }

    return redirect()->back()->withErrors([$this->message]);
  }
}
