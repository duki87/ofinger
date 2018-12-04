<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  use Notifiable;

  protected $guard = 'admin';

  public function details() {
    return $this->hasMany('App\ProductDetails', 'product_id');
  }

  protected $fillable = [
      'category_id', 'brand_id', 'name', 'price', 'price_discount', 'description', 'featured_image', 'images_folder', 'url', 'active'
  ];
}
