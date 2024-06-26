<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
  public function login()
  {
    return view('auth.login', [
      'title' => 'Login'
    ]);
  }

  public function authenticate(Request $request)
  {
    $incomingFields = $request->validate([
      'name' => ['required', 'exists:users,name'],
      'password' => ['required']
    ]);

    if (Auth::attempt($incomingFields)) {
      if (Gate::allows('read-gudang')) {
        return redirect()->intended('/gudang/order');
      }

      if (Gate::allows('read-ukur')) {
        return redirect()->intended('/ukur/order');
      }
    } else {
      return back()->withErrors(['password' => 'invalidCredentials']);
    }
  }

  public function logout()
  {
    Auth::logout();
    return redirect()->intended('/login');
  }
}
