<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use DataTables;
use Session;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index() {
        return view('admin.products.products');
    }

    public function add_product() {
        return view('admin.products.add-product');
    }

}
