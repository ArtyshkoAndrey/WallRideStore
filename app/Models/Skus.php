<?php

namespace App\Models;

use App\Exceptions\InternalException;
use Illuminate\Database\Eloquent\Model;

class Skus extends Model
{
  protected $fillable = ['title'];

  public function products()
  {
    return $this->belongsToMany(Product::class, 'product_skus', 'skus_id', 'product_id');
  }
}
