<?php

namespace App\Http\Controllers;

use App\ProductDetails;
use Illuminate\Http\Request;

class ProductDetailsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductDetails  $productDetails
     * @return \Illuminate\Http\Response
     */
    public function show(ProductDetails $productDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductDetails  $productDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductDetails $productDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductDetails  $productDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductDetails $productDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductDetails  $productDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductDetails $productDetails)
    {
        //
    }
}
