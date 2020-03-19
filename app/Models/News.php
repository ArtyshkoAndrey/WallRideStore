<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
  use SoftDeletes;
  protected $fillable = [
    'title', 'content', 'photo'
  ];
  protected $dates = ['deleted_at'];
}
