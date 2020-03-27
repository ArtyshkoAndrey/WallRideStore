<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
  protected $fillable = [
    'name', 'id'
  ];

  public function scopeWhereLike($query, $column, $value)
  {
    return $query->where($column, 'like', '%'.$value.'%');
  }

  public function categories() {
    return $this->belongsToMany(Category::class, 'brands_categories', 'brand_id', 'category_id');
  }
}
