<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use DataTables;
use Session;

class BrandController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth:admin');
  }

  public function index() {
      return view('admin.brands.brands');
  }

  public function add_brand() {
      return view('admin.brands.add-brand');
  }

  public function preview_brand_img(Request $request) {
    $image = $request->file('image');
    $extension = $request->file('image')->getClientOriginalExtension(); // getting excel extension
    $dir = 'images/brands/';
    $filename = uniqid().'_'.time().'_'.date('Ymd').'.'.$extension;
    $move = $request->file('image')->move($dir, $filename);
    $file_path = url('/').'/images/brands/'.$filename;
    if($move) {
      return response()->json(['image_src'=>$filename, 'image_path'=>$file_path]);
    }
  }

  public function remove_img(Request $request) {
    $file_path = public_path().'/images/brands/'.$request->path;
    $unlink = unlink($file_path);
    if($unlink) {
      return response()->json(['message'=>'IMG_DELETE']);
    }
  }

  public function create_brand(Request $request) {
    $brand = new Brand;
    $brand->name = $request->name;
    $brand->description = $request->description;
    $brand->image = $request->image;
    $brand->url = $request->url;
    $brand->active = $request->active;
    $brand->save();

    if($brand) {
      return response()->json(['success'=>'BRAND_ADD']);
    }
  }

  public function edit_brand($url) {
    $brand = Brand::where(['url' => $url])->first();
    return view('admin.brands.edit-brand')->with('brand', $brand);
  }

  public function get_brands_table() {
    $brands = Brand::select('id', 'name', 'image', 'url', 'active');

    return DataTables::of($brands)
    ->editColumn('active', function(Brand $brand) {
        $id = $brand->id;
        $url = $brand->url;
        return '<a href="'. route('admin.edit-brand', ['url' => $url]) .'" name="edit" data-id="'.$id.'" class="btn btn-success edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="" name="delete-brand" id="'.$id.'" data-id="'.$id.'" class="btn btn-danger delete-brand"><i class="fa fa-trash" aria-hidden="true"></i></a>';
      })

    ->editColumn('image', function(Brand $brand) {
        $image = $brand->image;
        return '<img src="http://localhost/ofinger/public/images/brands/'.$image.'" alt="" style="width:50px; height:auto">';
      })

    ->addColumn('status', function(Brand $brand) {
      if($brand->active == 1) {
        return '<span class="label label-success">Активан</span>';
      } else {
        return '<span class="label label-danger">Неaктиван</span>';
      }
    })->rawColumns(['name', 'image', 'status', 'url', 'active'])
          ->make(true);
  }

  public function get_brand_data(Request $request) {
    $id = $request->id;
    $brand = Brand::where(['id' => $id])->first();
    $full_img_path = url('/').'/images/brands/'.$brand->image;
    return response()->json([
      'id'=>$brand->id,
      'name'=>$brand->name,
      'description'=>$brand->description,
      'image'=>$brand->image,
      'url'=>$brand->url,
      'active'=>$brand->active,
      'full_img_path'=>$full_img_path
    ]);
  }

  public function remove_brand(Request $request) {
    $brand = Brand::where(['id' => $request->id])->first();
    $name = $brand->name;
    $file_path = public_path().'/images/brands/'.$brand->image;
    unlink($file_path);
    Brand::where(['id' => $request->id])->delete();
    return response()->json(['name'=>$name, 'success'=>'BRAND_DELETE']);
  }

  public function update_brand(Request $request) {
    Brand::where(['id' => $request->id])->update([
      'id'=>$request->id,
      'name'=>$request->name,
      'description'=>$request->description,
      'image'=>$request->image,
      'url'=>$request->url,
      'active'=>$request->active
    ]);
    $public_path = url('/').'/admin/brands/';
    Session::flash('brand_message', 'Произвођач '.$request->name.' је успешно измењен!');
    return response()->json(['public_path'=>$public_path]);
  }

  public function get_all_brands() {
    $brand_data = array();
    $brands = Brand::get();
    foreach ($brands as $brand) {
      $brand_data[] = '<option value="'.$brand->id.'">'.$brand->name.'</option>';
    }
    return response()->json(['brand_data'=>$brand_data]);
  }
}
?>
