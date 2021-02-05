<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model implements TranslatableContract
{
  use HasFactory;
  use Translatable;
  use SoftDeletes;

  public array $translatedAttributes = [
    'title', 'description',
  ];

  protected $fillable = [
    'on_sale',
    'on_new',
    'on_top',
    'sold_count',
    'price',
    'price_sale',
    'weight',
    'meta'
  ];

  protected $casts = [
    'on_sale' => 'boolean',
    'on_new' => 'boolean',
    'on_top' => 'boolean',
    'meta' => 'object',
  ];

  protected $dates = ['deleted_at'];

  protected $attributes = [
    'meta' => '{
      "description": "",
      "title": ""
    }'
  ];
}
