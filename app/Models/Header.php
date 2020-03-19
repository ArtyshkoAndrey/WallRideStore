<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
  protected $fillable = [
    'photo', 'url', 'h1', 'h2', 'btn_text'
  ];
}
