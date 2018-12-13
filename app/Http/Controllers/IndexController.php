<?php

namespace App\Http\Controllers;
use App\Product;
use App\Category;
use App\Brand;
use App\ProductDetails;

use Illuminate\Http\Request;

class IndexController extends Controller
{
  public function index() {
    $productsArr = Product::with('details')->limit(3)->get();
    $products = array();
    foreach ($productsArr as $product) {
      $img_path = url('/').'/images/products/'.$product->images_folder.'/'.$product->featured_image;
      $category = Category::where('id', $product->category_id)->first();
      $cat_name = $category->name;
      $cat_id = $category->id;
      $cat_url = $category->url;
      $brand = Brand::where('id', $product->brand_id)->first();
      $brand_name = $brand->name;
      $product['cat_name'] = $cat_name;
      $product['brand_name'] = $brand_name;
      $product['img_path'] = $img_path;
      $product['cat_id'] = $cat_id;
      $product['cat_url'] = $cat_url;
      $products[] = $product;
    }
    return view('index')->with('products', $products);
  }

  public function category($url) {
    return view('front.category');
  }

  public static function categories_menu() {
    $categories = array();
    $parent_categories = Category::where(['id'=>0])->get();
    foreach ($parent_categories as $parent_category) {
      $child_categories = Category::where(['parent_id'=>$parent_category->id])->get();
      $categories[$parent_category->id] = $child_categories;
    }
    return $categories;
  }

  public static function brands_menu() {
    $brands = Brand::get();
    return $brands;
  }
}
