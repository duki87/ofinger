<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Brand;
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
      $product->brand_id =  $request->brand_id;
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

    public function get_products_table() {
      $product = Product::with('details')->select('id', 'category_id', 'brand_id', 'name', 'url', 'featured_image', 'images_folder', 'active', 'id');

      return DataTables::of($product)
      ->editColumn('active', function(Product $product) {
          $id = $product->id;
          $url = $product->url;
          return '<a href="'. route('admin.edit-product', ['url' => $url]) .'" name="edit" data-id="'.$id.'" class="btn btn-success edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="" name="delete-product" id="'.$id.'" data-id="'.$id.'" class="btn btn-danger delete-product"><i class="fa fa-trash" aria-hidden="true"></i></a>';
        })

      ->editColumn('featured_image', function(Product $product) {
          $image = $product->featured_image;
          $images_folder = $product->images_folder;
          $path = url('/').'/images/products/'.$images_folder.'/'.$image;
          return '<img src="'.$path.'" alt="" style="width:50px; height:auto">';
        })

      ->addColumn('status', function(Product $product) {
        if($product->active == 1) {
          return '<span class="label label-success">Активна</span>';
        } else {
          return '<span class="label label-danger">Неaктивна</span>';
        }
      })

      ->editColumn('brand_id', function(Product $product) {
          $brand_id = $product->brand_id;
          $brand = Brand::where('id', $brand_id)->first();
          $brand_name = $brand['name'];
          return '<span class="label label-info">'.$brand_name.'</span>';
        })

      ->editColumn('category_id', function(Product $product) {
          $category_id = $product->category_id;
          $category = Category::where('id', $category_id)->first();
          $category_name = $category->name;
          $parent_id = $category->parent_id;
          $parent_cat = Category::where('id', $parent_id)->first();
          $parent_name = $parent_cat->name;
          return '<span class="label label-info">'.$parent_name.'->'.$category_name.'</span>';
        })

        ->addColumn('id', function(Product $product) {
          $product_id = $product->id;
          $product_var = ProductDetails::where('product_id', $product_id)->count();
          return '<span class="label label-info">'.$product_var.'</span>';
        })->rawColumns(['active', 'featured_image', 'status', 'brand_id', 'category_id', 'id'])
            ->make(true);
    }

    public function edit_product($url) {
      $category = Product::where(['url' => $url])->first();
      return view('admin.products.edit-product');
    }

    public function remove_product(Request $request) {
      $product = Product::where(['id' => $request->id])->first();
      $name = $product->name;
      $images_folder = $product->images_folder;
      File::deleteDirectory(public_path('images/products/'.$images_folder));
      Product::where(['id' => $request->id])->delete();
      ProductDetails::where(['product_id' => $request->id])->delete();
      return response()->json(['name'=>$name, 'success'=>'PRODUCT_DELETE']);
    }

}
