<?php

namespace App\Http\Controllers;
use App\Product;
use App\Cart;
use App\Category;
use App\Brand;
use App\ProductDetails;
use Illuminate\Http\Request;
use Session;

class CartController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function show_cart() {
    $item = array();
    $data = array();
    if(Session::has('cart')) {
      $cart = Session::get('cart');
      foreach ($cart as $key => $product) {
        $product_data = Product::where('id', $key)->first();
        $item['name'] = $product_data->name;
        $item['product_id'] = $product_data->id;
        $item['price'] = $product_data->price;
        $item['image'] = $product_data->images_folder.'/'.$product_data->featured_image;
        foreach ($product as $sku_id => $sub_product) {
          $sub_product_data = ProductDetails::where('id', $sku_id)->first();
          $item['sku'] = $sub_product_data->sku;
          $item['sku_id'] = $sku_id;
          $item['quantity'] = $sub_product['quantity'];
        }
        $data[] = $item;
      }
    }
    return view('front.cart')->with(['data' => $data]);
  }

  public function add_to_cart(Request $request) {

    $sku_item = [$request->sku_id => ['sku_id' => $request->sku_id, 'quantity' => $request->sku_qty]];
    $item = [$request->product_id => $sku_item];

    if($request->session()->has('cart')) {
      $cart_menu = '';
      $cart = $request->session()->get('cart');
      if(array_key_exists($request->product_id, $cart)) {
        if(array_search($request->sku_id, $cart[$request->product_id])) {
          $cart[$request->product_id][$request->sku_id]['quantity'] = $request->sku_qty;
          $request->session()->forget('cart');
          $request->session()->put('cart', $cart);
          return response()->json(['success'=>$cart, 'cart_menu' => $cart_menu]);
        } else {
          $cart[$request->product_id][$request->sku_id] = ['sku_id' => $request->sku_id, 'quantity' => $request->sku_qty];
          $request->session()->forget('cart');
          $request->session()->put('cart', $cart);
          return response()->json(['success'=>$cart, 'cart_menu' => $cart_menu]);
        }
      } else {
        $cart[$request->product_id] = $sku_item;
        $request->session()->forget('cart');
        $request->session()->put('cart', $cart);
        return response()->json(['success'=>$cart, 'cart_menu' => $cart_menu]);
      }
    } else {
      $cart_menu = '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-shopping-cart"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="'.route('front.cart').'">Погледај корпу</a>
                      <a class="dropdown-item" href="#">наплати</a>
                    </div>';
      $request->session()->put('cart', $item);
      return response()->json(['success'=>$request->session()->get('cart'), 'cart_menu' => $cart_menu]);
    }
  }

  public function update_cart(Request $request) {
    $cart = $request->session()->get('cart');
    if(array_key_exists($request->product_id, $cart)) {
      if(array_key_exists($request->sku_id, $cart[$request->product_id])) {
        return response()->json(['success'=>$cart]);
        $cart[$request->product_id][$request->sku_id]['quantity'] = $request->quantity;
        $request->session()->forget('cart');
        $request->session()->put('cart', $cart);
        return response()->json(['success'=>'CART_UPDATE']);
      }
    }
  }

}

?>
