<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller {
  public function __constructor(){
    $this->middleware('guest:admin', ['except' => ['logout']]);
  }

  public function showLoginForm() {
    return view('admin.login');
  }

  public function login (Request $request){
    // Validate The form
    $this->validate($request, [
      'email' => 'required|email',
      'password' => 'required|min:6',
    ]);

    // Attempt to log the user in
    if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
      // if successful, then redirect to their intendd location
      return redirect()->intended(route('admin.dashboard'));
    }

    // If unsuccessful, then redirect back to the login with the form data
    return redirect()->back()->withInput($request->only('email', 'remember'));

  }

  public function logout()
  {
    Auth::guard('admin')->logout();
    return redirect('/admin');
  }
}
