<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Currency;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return Factory|View
  */
  public function index()
  {
    $address = UserAddress::where('user_id', auth()->id())->first();
    $currencies = Currency::all();
    return view('profile.index', compact('address', 'currencies'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return void
   */
  public function create()
  {
      //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return void
   */
  public function store(Request $request)
  {
      //
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return void
   */
  public function show($id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return void
   */
  public function edit($id)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param  int  $id
   * @return RedirectResponse|Redirector
   */
  public function update(Request $request, $id)
  {
    $user = User::find($id);
    if ($request->metadata === 'address') {
      if ($user->email != $request->email) {
        $request->validate([
          'country' => 'required|exists:countries,id',
          'city' => 'required|exists:cities,id',
          'street' => 'required|max:255',
          'contact_phone' => 'required|max:255',
          'currency' => 'required',
          'name' => 'required',
          'email' => 'required', 'string', 'email', 'max:255', 'unique:users'
        ]);
      } else {
        $request->validate([
          'country' => 'required|exists:countries,id',
          'city' => 'required|exists:cities,id',
          'street' => 'required|max:255',
          'contact_phone' => 'required|max:255',
          'currency' => 'required',
          'name' => 'required'
        ]);
      }
      if ($user->address == null) {
        $address = new UserAddress();
        $address['street'] = $request->street;
        $address['contact_phone'] = $request->contact_phone;
        $currency = Currency::find($request->currency);
        $address->currency()->associate($currency);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address->city()->associate(City::find($request->city));
        $user->address->country()->associate(Country::find($request->ccountry));
        $user->address()->save($address);
        $user->save();
      } else {
        $user->address->update([
          'street' => $request->street,
          'contact_phone' => $request->contact_phone
        ]);
        $currency = Currency::find($request->currency);
        $user->address->currency()->associate($currency);
        $user->address->city()->associate(City::find($request->city));
        $user->address->country()->associate(Country::find($request->country));
        $user->address->save();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
      }
      return redirect()->route('profile.index')->with('status', 'Данные профиля обновлены');
    } else if ($request->metadata === 'password') {
      $request->validate([
        'password' => 'required|confirmed'
      ]);
      $user->password = Hash::make($request->password);
      $user->save();
      return redirect()->route('profile.index')->with('status', 'Пароль изменён');
    } else if ($request->metadata === 'photo') {
      $image = $request->file('photo');

      $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

      $destinationPath = public_path('storage/avatar/thumbnail');

      $img = Image::make($image->getRealPath());
      $image = $img;
      $img->resize(200, 200, function ($constraint) {

        $constraint->aspectRatio();

      })->save($destinationPath.'/'.$input['imagename']);

      /*After Resize Add this Code to Upload Image*/
//      $destinationPath = public_path('storeage/avatar');
//      $image->save($destinationPath.'/'.$input['imagename']);
//      $image->move($destinationPath, $input['imagename']);
      $user->avatar = $input['imagename'];
      $user->save();
      return redirect()->route('profile.index')->with('status', 'Фотография обновлена');
    } else {
      return redirect()->route('root');
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return void
   */
  public function destroy($id)
  {
      //
  }
}
