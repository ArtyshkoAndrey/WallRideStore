<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

  protected $fillable = [
    'name', 'id'
  ];

  protected $casts = [
    'is_brand' => 'boolean'
  ];

  public function categories()
  {
    return $this->hasMany(Category::class, 'id', 'category_id')->with('categories');
  }

  public function childrenCategories()
  {
    return $this->hasMany(Category::class)->with('categories');
  }
  public function scopeWhereLike($query, $column, $value)
  {
    return $query->where($column, 'like', '%'.$value.'%');
  }

}
