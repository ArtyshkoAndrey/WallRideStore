<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model {
  
  protected $fillable = ['title', 'image', 'content'];

  public function getImage() {
    if (isset($this->image) && $this->image !== 'no image')
      return asset('storage/faq/' . $this->image);

    return 'https://developers.google.com/maps/documentation/maps-static/images/error-image-generic.png';
  }
}
