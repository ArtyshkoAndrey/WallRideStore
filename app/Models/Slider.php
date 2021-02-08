<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Slider extends Model implements TranslatableContract
{
  use HasFactory;
  use Translatable;

  public array $translatedAttributes = [
    'h1',
    'h2',
    'btn_text'
  ];

  protected $fillable = [
    'url',
    'photo',
    'mobile_photo',
  ];

  protected $appends = [
    'photo_url',
    'photo_mobile_url'
  ];

  public function getPhotoUrlAttribute (): string
  {
    return storage_path('storage/slider/photos/' . $this->photo);
  }

  public function getPhotoMobileUrlAttribute (): string
  {
    return storage_path('storage/slider/mobile/' . $this->mobile_photo);
  }
}
