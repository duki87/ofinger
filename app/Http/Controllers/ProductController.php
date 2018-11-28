<?php

namespace App\Http\Controllers;

use App\Product;
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
        return response()->json(['folder_name'=>$folder_name, 'images'=>$imagesArr, 'path'=>$path, 'last'=>$count-1]);
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
      $file_path = public_path().'/images/brands/'.$request->path;
      $unlink = unlink($file_path);
      if($unlink) {
        return response()->json(['message'=>'IMG_DELETE']);
      }
    }

}
