<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeaderMobile extends Model
{
  protected $fillable = [
    'photo', 'url', 'h1', 'h2', 'btn_text'
  ];
}
