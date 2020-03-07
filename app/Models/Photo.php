<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model {
  protected $fillable = [
    'name'
  ];

  protected $table = 'products_image';

  public function product() {
    return $this->belongsTo(Product::class, 'product_id', 'id')->withTrashed();
  }
}
