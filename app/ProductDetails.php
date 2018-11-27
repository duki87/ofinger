<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDetails extends Model
{
  use Notifiable;

  protected $guard = 'admin';

  protected $fillable = [
      'product_id', 'sku', 'size', 'color', 'stock', 'active'
  ];
}
