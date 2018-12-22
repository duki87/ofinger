<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Session;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout', 'userLogout');
    }

    public function login(Request $request) {
      //validate form data
      $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required|min:6'
      ]);
      //attempt to login user
      if(Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
      //if successfull
        $user = User::where('email', $request->email)->first();
        Session::put('user_id', Auth::guard('web')->id());
        Session::put('user_name', $user->name);
        return redirect()->intended(route('user'));
      } else {
        //if unsuccessfull
        return redirect()->back()->withInput($request->only('email', 'remember'));
      }
    }

    public function userLogout() {
      Auth::guard('web')->logout();
      Session::forget('user_id');
      Session::forget('user_name');
      //return $this->loggedOut($request) ?: redirect('/');
      return redirect()->route('index');
    }
}
