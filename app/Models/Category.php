<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  public function categories()
  {
    return $this->hasMany(Category::class);
  }

  public function childrenCategories()
{
    return $this->hasMany(Category::class)->with('categories');
}
}
