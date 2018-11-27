<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use DataTables;
use Session;

class CategoryController extends Controller
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
    public function index() {
        return view('admin.categories.categories');
    }

    public function add_category() {
        return view('admin.categories.add-category');
    }

    public function preview_category_img(Request $request) {
      $image = $request->file('image');
      $extension = $request->file('image')->getClientOriginalExtension(); // getting excel extension
      $dir = 'images/categories/';
      $filename = uniqid().'_'.time().'_'.date('Ymd').'.'.$extension;
      $move = $request->file('image')->move($dir, $filename);
      $file_path = url('/').'/images/categories/'.$filename;
      if($move) {
        return response()->json(['image_src'=>$filename, 'image_path'=>$file_path]);
      }
    }

    public function remove_img(Request $request) {
      $file_path = public_path().'/images/categories/'.$request->path;
      $unlink = unlink($file_path);
      if($unlink) {
        return response()->json(['message'=>'IMG_DELETE']);
      }
    }

    public function create_category(Request $request) {
      $category = new Category;
      $category->parent_id = $request->parent_id;
      $category->name = $request->name;
      $category->description = $request->description;
      $category->image = $request->image;
      $category->url = $request->url;
      $category->active = $request->active;
      $category->save();

      if($category) {
        return response()->json(['success'=>'CATEGORY_ADD']);
      }
    }

    public function get_parent_categories() {
      $data = array();
      $categories = Category::where(['parent_id' => 0])->get();
      foreach ($categories as $category) {
        $data[] = '<option value="'.$category->id.'">'.$category->name.'</option>';
      }
      return response()->json(['categories'=>$data]);
    }

    public function get_child_categories(Request $request) {
      $data = array();
      $parent_id = $request->parent_id;
      $categories = Category::where(['parent_id' => $parent_id])->get();
      foreach ($categories as $category) {
        $data[] = '<option value="'.$category->id.'">'.$category->name.'</option>';
      }
      return response()->json(['categories'=>$data]);
    }

    public function get_categories_table() {
      $categories = Category::select('id', 'parent_id', 'name', 'image', 'url', 'active');

      return DataTables::of($categories)
      ->editColumn('active', function(Category $category) {
          $id = $category->id;
          $url = $category->url;
          return '<a href="'. route('admin.edit-category', ['url' => $url]) .'" name="edit" data-id="'.$id.'" class="btn btn-success edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="" name="delete-category" id="'.$id.'" data-id="'.$id.'" class="btn btn-danger delete-category"><i class="fa fa-trash" aria-hidden="true"></i></a>';
        })

      ->editColumn('image', function(Category $category) {
          $image = $category->image;
          return '<img src="http://localhost/ofinger/public/images/categories/'.$image.'" alt="" style="width:50px; height:auto">';
        })

      ->addColumn('status', function(Category $category) {
        if($category->active == 1) {
          return '<span class="label label-success">Активна</span>';
        } else {
          return '<span class="label label-danger">Неaктивна</span>';
        }
      })

      ->editColumn('parent_id', function(Category $category) {
          $parent_id = $category->parent_id;
          if($parent_id == 0) {
            return '<span class="label label-primary">Главна категорија</span>';
          } else {
            $parent = Category::where(['id' => $parent_id])->first();
            return 'Подкатегорија за ' . '<span class="label label-info">' . $parent->name . '</span>';
          }
        })->rawColumns(['active', 'image', 'status', 'parent_id'])
            ->make(true);
    }

    public function edit_category($url) {
      $category = Category::where(['url' => $url])->first();
      return view('admin.categories.edit-category')->with('category', $category);
    }

    public function remove_category(Request $request) {
      $category = Category::where(['id' => $request->id])->first();
      $name = $category->name;
      $file_path = public_path().'/images/categories/'.$category->image;
      unlink($file_path);
      Category::where(['id' => $request->id])->delete();
      return response()->json(['name'=>$name, 'success'=>'CATEGORY_DELETE']);
    }

    public function get_category_data(Request $request) {
      $id = $request->id;
      $parents = Category::get();
      $parent_categories = array();
      $category = Category::where(['id' => $id])->first();
      foreach ($parents as $parent) {
        if($parent->id == $category->parent_id) {
          $option = 'selected';
        } else {
          $option = '';
        }
        $parent_categories[] = '<option value="'.$parent->id.'" '.$option.'>'.$parent->name.'</option>';
      }
      $full_img_path = public_path().'/images/categories/'.$category->image;
      return response()->json([
        'id'=>$category->id,
        'parent_id'=>$category->parent_id,
        'name'=>$category->name,
        'description'=>$category->description,
        'image'=>$category->image,
        'url'=>$category->url,
        'active'=>$category->active,
        'parent_categories'=>$parent_categories,
        'full_img_path'=>$full_img_path
      ]);
    }

    public function update_category(Request $request) {
      Category::where(['id' => $request->id])->update([
        'id'=>$request->id,
        'parent_id'=>$request->parent_id,
        'name'=>$request->name,
        'description'=>$request->description,
        'image'=>$request->image,
        'url'=>$request->url,
        'active'=>$request->active
      ]);
      $public_path = url('/').'/admin/categories/';
      Session::flash('category_message', 'Категорија '.$request->name.' је успешно измењена!');
      return response()->json(['public_path'=>$public_path]);
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
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
