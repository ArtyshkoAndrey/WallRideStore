<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ParserEmsService;
use File;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\View;
use JsonException;

class HomeController extends Controller
{

  /**
   * Index Page
   *
   * @return View
   * @throws BindingResolutionException
   * @throws JsonException
   * @throws FileNotFoundException
   */
  public function index(): View
  {
    $change = File::get('public/change.json');
    $change = json_decode($change, true, 512, JSON_THROW_ON_ERROR);
    $change = $change['admin'];
    return view('admin.index', compact('change'));
  }

  public function redirect()
  {
    return redirect()->route('admin.index')->withSuccess(['Это новые тестовые уведомления, Добро пожаловать'])->withErrors(['Это новые тестовые уведомления, Добро пожаловать']);
  }

  public function emstest() {

    $emsService = new ParserEmsService($data['post_code'], $data['country_code'], $data['weight']);
    $price = $emsService->getPrice();
    dump($emsService);
  }
}
