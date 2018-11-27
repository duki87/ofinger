<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  use Notifiable;

  protected $guard = 'admin';

  public function images() {
    return $this->hasMany('App\ProductImages', 'product_id');
  }

  protected $fillable = [
      'category_id', 'brand_id', 'name', 'price', 'description', 'featured_image', 'url', 'active'
  ];
}
