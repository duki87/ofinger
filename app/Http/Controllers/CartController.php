<?php

namespace App\Http\Controllers;
// use App\Product;
// use App\Cart;
// use App\Category;
// use App\Brand;
// use App\ProductDetails;
use Illuminate\Http\Request;
use Session;

class CartController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function view_cart()
  {
      // $this->middleware('auth');
  }

  public function add_to_cart(Request $request) {

    $sku_item = [$request->sku_id => ['sku_id' => $request->sku_id, 'quantity' => $request->sku_qty]];
    $item = [$request->product_id => $sku_item];

    if($request->session()->has('cart')) {
      $cart = $request->session()->get('cart');
      if(array_key_exists($request->product_id, $cart)) {
        if(array_search($request->sku_id, $cart[$request->product_id])) {
          $cart[$request->product_id][$request->sku_id]['quantity'] = $request->sku_qty;
          $request->session()->forget('cart');
          $request->session()->put('cart', $cart);
          return response()->json(['success'=>$cart]);
        } else {
          $cart[$request->product_id][$request->sku_id] = ['sku_id' => $request->sku_id, 'quantity' => $request->sku_qty];
          $request->session()->forget('cart');
          $request->session()->put('cart', $cart);
          return response()->json(['success'=>$cart]);
        }
      } else {
        $cart[$request->product_id] = $sku_item;
        $request->session()->forget('cart');
        $request->session()->put('cart', $cart);
        return response()->json(['success'=>$cart]);
      }
    } else {
      $request->session()->put('cart', $item);
      return response()->json(['success'=>$request->session()->get('cart')]);
    }
  }
}

?>
