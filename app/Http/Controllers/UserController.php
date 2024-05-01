<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  public function login(Request $request)
  {
    $incomingFields = $request->validate([
      'name' => ['required', 'exists:users,name'],
      'password' => ['required']
    ]);

    if (Auth::attempt($incomingFields)) {
      return redirect()->intended('/beranda');
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
