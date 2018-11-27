<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{
    public function __construct() {
      //$this->middleware('guest:admin', ['except' => ['logout']]);
      $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm() {
      return view('auth.admin-login');
    }

    public function login(Request $request) {
      //validate form data
      $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required|min:6'
      ]);
      //attempt to login user
      if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
      //if successfull
        return redirect()->intended(route('admin.dashboard'));
        //return Redirect('/admin');
      } else {
        //if unsuccessfull
        return redirect()->back()->withInput($request->only('email', 'remember'));
      }
    }

    public function logout() {
      Auth::guard('admin')->logout();
      //return $this->loggedOut($request) ?: redirect('/');
      return redirect('/admin/login');
    }
}
