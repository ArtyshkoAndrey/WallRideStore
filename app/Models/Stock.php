<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model {

  protected $fillable = ['title', 'image', 'description', 'link', 'text_to_link', 'view', 'on_auth', 'delay'];
  protected $casts = [
    'on_auth' => 'boolean'
  ];

  public function getImage() {
    if (isset($this->image))
      return asset('storage/stocks/' . $this->image);

    return 'https://developers.google.com/maps/documentation/maps-static/images/error-image-generic.png';
  }
}
