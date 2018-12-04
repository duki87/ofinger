<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductDetails;
use Illuminate\Http\Request;
use DataTables;
use Session;
use Illuminate\Support\Facades\File;

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

    public function preview_product_img(Request $request) {
      if($request->has('folder_name')) {
        $imagesArr = array();
        $dir = 'images/products/'.$request->folder_name;
        $folder_name = $request->folder_name;
        $count = $request->next_image;
        $images = $request->file('images');
        foreach($images as $image){
          $tmp_name = $image->getClientOriginalName();
          $extension = $image->getClientOriginalExtension();
          $file_name = 'image' . '-' . $count . '.' . $extension;
          if($image->move($dir, $file_name)) {
            $imagesArr[] = $file_name;
            $count++;
          }
        }
        $path = url('/').'/'.$dir.'/';
        return response()->json(['folder_name'=>$folder_name, 'images'=>$imagesArr, 'path'=>$path]);
      } else {
        $images = $request->file('images');
        $imagesArr = array();
        $folder_name = date('Ymd').'-'.time().'-'.uniqid();
        $dir = 'images/products/'.$folder_name;
        $count = 1;
        if(File::makeDirectory($dir)) {
          foreach($images as $image){
            $tmp_name = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $file_name = 'image' . '-' . $count . '.' . $extension;
            if($image->move($dir, $file_name)) {
              $imagesArr[] = $file_name;
              $count++;
            }
          }
          $path = url('/').'/'.$dir.'/';
          return response()->json(['folder_name'=>$folder_name, 'images'=>$imagesArr, 'path'=>$path]);
        }
      }
    }

    public function remove_img(Request $request) {
      $image = $request->image;
      $folder = $request->folder;
      $file_path = public_path().'/images/products/'.$folder.'/'.$image;
      $unlink = unlink($file_path);
      if($unlink) {
        return response()->json(['message'=>'IMG_DELETE']);
      }
    }

    public function remove_folder_img(Request $request) {
      $folder = $request->folder;
      if(File::deleteDirectory(public_path('images/products/'.$folder))) {
        return response()->json(['success'=>'FOLDER_DELETE']);
      }
    }

    public function create_product(Request $request) {
      $product = new Product;
      $product->category_id = $request->category_id;
      $product->brand_id = 2;
      $product->name = $request->name;
      $product->price = $request->price;
      $product->price_discount = $request->price_discount;
      $product->description = $request->description;
      $product->featured_image = $request->featured_image;
      $product->images_folder = $request->folder_name;
      $product->url = $request->url;
      $product->active = $request->active;
      //$product->save();
      if($product->save()) {
        $lastInsertedId = $product->id;
        //$product_details = new ProductDetails;
        $product_alts = json_decode($request->product_details, true);
        foreach ($product_alts as $alt) {
          //echo $value['sku'] . $value['color'] . $value['size'] . $value['stock'] . '<br>';
          $product_details = new ProductDetails;
          $product_details->product_id = $lastInsertedId;
          $product_details->sku = $alt['sku'];
          $product_details->color = $alt['color'];
          $product_details->size = $alt['size'];
          $product_details->stock = $alt['stock'];
          $product_details->active = 1;
          $product_details->save();
        }
      }
      return response()->json(['success'=>'PRODUCT_ADD', 'name'=>$request->name]);
    }

}
