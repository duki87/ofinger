<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  use Notifiable;

  protected $guard = 'admin';

  protected $fillable = [
      'parent_id', 'name', 'description', 'image', 'url', 'active'
  ];
}
