<?php

namespace App\Http\Controllers;
use App\Product;
use App\Category;
use App\Brand;
use App\ProductDetails;
use Session;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function user() {
      return view('front.user');
    }

    public function login() {
      if(Session::has('user_id')) {
        return redirect()->route('user');
      }
      return view('auth.login');
    }
}
