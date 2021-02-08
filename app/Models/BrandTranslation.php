<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandTranslation extends Model
{

  public $timestamps = false;

  protected $fillable = [
    'name',
    'description'
  ];
}
