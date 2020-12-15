<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\NotificationMail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class NotificationController extends Controller
{
  public function __construct(CartService $cartService)
  {
//    parent::__construct($cartService);
  }

  public function index () {
    return view('admin.notification.send');
  }

  public function create (Request $request) {
    $data = $request->all();
    $users = User::whereNotification(true)->get();
    foreach ($users as $user) {
      NotificationMail::dispatch($data, $user);
    }
    return redirect()->route('admin.user.index')->withSuccess(['Сообщения успешно отправленные']);
  }

  public function photoDelete(Request $request) {
    File::delete(public_path('storage/email') . '/' .$request->name);
    return $request->name;
  }

  public function photoCreate(Request $request) {
    $image = $request->file('file');
    $destinationPath = public_path('storage/email');
    $name = $request->file('file')->getClientOriginalName();
    $img = Image::make($image->getRealPath());
    $img->save($destinationPath.'/'.$name);
    return $name;
  }
}
