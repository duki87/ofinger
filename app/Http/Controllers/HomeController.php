<?php

namespace App\Http\Controllers;
use App\Product;
use App\Category;
use App\Brand;
use App\ProductDetails;

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
    public function index() {
      return view('home');
    }
}
