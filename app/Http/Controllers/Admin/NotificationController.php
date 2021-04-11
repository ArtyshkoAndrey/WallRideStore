<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendUsersNotification;
use App\Services\PhotoService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|View
   * @throws BindingResolutionException
   */
  public function index()
  {
    return view('admin.notification.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return void
   */
  public function create(): void
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return RedirectResponse
   */
  public function store(Request $request): RedirectResponse
  {
    $request->validate([
      'title' => 'required|string',
      'content' => 'required|string',
      'image' => 'required|file'
    ]);

    $image = PhotoService::create($request->file('image'), 'storage/notifications/', true, 60, true, 1200);
    $image = asset('storage/notifications/' . $image . '.jpg');

    $users = User::whereNotification(true)->get();
    foreach ($users as $user) {
      $user->notify(new SendUsersNotification($image, $request->get('title'), $request->get('content'), $user->email));
    }

    return redirect()->back()->with('success', ['Сообщение отправлено']);
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return void
   */
  public function show(int $id): void
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return void
   */
  public function edit(int $id): void
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param int $id
   * @return void
   */
  public function update(Request $request, int $id): void
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return void
   */
  public function destroy(int $id): void
  {
    //
  }
}
