<?php

namespace App\Http\Controllers;
use App\Product;
use App\Category;
use App\Brand;
use App\ProductDetails;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
    $category = Category::where(['url' => $url])->first();
    $cat_name = $category->name;
    $productsArr = Product::where(['category_id' => $category->id])->get();
    $products = array();
    foreach ($productsArr as $product) {
      $photos = File::allFiles(public_path('images/products/'.$product->images_folder));
      $img_path = url('/').'/images/products/'.$product->images_folder.'/'.$product->featured_image;
      $brand = Brand::where('id', $product->brand_id)->first();
      $brand_name = $brand->name;
      $product['brand_name'] = $brand_name;
      $product['img_path'] = $img_path;
      $product['photos'] = $photos;
      $products[] = $product;
    }
    return view('front.category')->with(['products' => $products, 'cat_name' => $cat_name]);
  }

  public function brand($url) {
    return view('front.brand');
  }

  public function product($url) {
    $photos = array();
    $product = Product::where(['url' => $url])->first();
    //$photos = File::get(url('/').'/images/products/'.$product->images_folder);
    //$files = Storage::files(url('/').'/images/products/'.$product->images_folder);
    $files = array_diff(scandir(public_path('images/products/'.$product->images_folder)), array('..', '.'));
    foreach ($files as $file) {
      $photos[] = url('/').'/images/products/'.$product->images_folder.'/'.$file;
    }
    $brand = Brand::where(['id' => $product->brand_id])->first();
    $brand_name = $brand->name;
    $brand_logo = url('/').'/images/brands/'.$brand->image;
    $category = Category::where(['id' => $product->category_id])->first();
    $cat_name = $category->name;
    return view('front.product')->with(['product' => $product, 'photos' => $photos, 'brand_name' => $brand_name, 'cat_name' => $cat_name, 'brand_logo' => $brand_logo]);
  }

  public static function categories_menu() {
    $categories = '';
    $parent_categories = Category::where(['parent_id'=>0])->get();
    foreach ($parent_categories as $parent_category) {
      $child_categories = Category::where(['parent_id' => $parent_category->id])->get();
      $categories .= '<div class="accordion"><div class="list-group"><a class="list-group-item list-group-item-action acc-parcat-link-item" data-toggle="collapse" href="#'.$parent_category->id.'">'.$parent_category->name.'</a></div>
               <div id="'.$parent_category->id.'" class="collapse show" data-parent="#catAccordion">
               <div class="list-group">';
      foreach ($child_categories as $child_category) {
        $categories .= '<a class="list-group-item list-group-item-action acc-subcat-link-item" href="'. route('front.category', ['url' => $child_category->url]) .'">'.$child_category->name.'</a>';
      }
      $categories .= '</div></div></div>';
    }
    return $categories;
  }

  // public static function categories_menu() {
  //   $categories = '';
  //   $parent_categories = Category::where(['parent_id'=>0])->get();
  //   foreach ($parent_categories as $parent_category) {
  //     $child_categories = Category::where(['parent_id'=>$parent_category->id])->get();
  //     $categories .= '<div class="list-group"><div class=""><a class="list-group-item list-group-item-action acc-parcat-link-item" data-toggle="collapse" href="#'.$parent_category->id.'">'.$parent_category->name.'</a></div>
  //              <div id="'.$parent_category->id.'" class="" data-parent="#catAccordion">
  //              <div class="list-group">';
  //     foreach ($child_categories as $child_category) {
  //       $categories .= '<a class="list-group-item list-group-item-action acc-subcat-link-item" href="'. route('front.category', ['url' => $child_category->url]) .'">'.$child_category->name.'</a>';
  //     }
  //     $categories .= '</div></div></div>';
  //   }
  //   //'. route('admin.edit-brand', ['url' => $url]) .'
  //   return $categories;
  // }

  public static function brands_menu() {
    $brands = Brand::get();
    return $brands;
  }
}
