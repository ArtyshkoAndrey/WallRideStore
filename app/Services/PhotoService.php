<?php
/*
 * Copyright (c) 2021. Данный файл является интелектуальной собственостью Fulliton.
 * Я буду рад если вы будите вносить улучшения, всегда жду ваших пул реквестов
 */

namespace App\Services;

use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class PhotoService
{
  protected static array $type = [
    'jpg',
    'webp'
  ];

  /**
   * @param $image
   * @param string $path
   * @param bool $cube
   * @param int $quality
   * @param bool $strRand
   * @param int|null $width
   * @param int|null $height
   * @return string
   */
  public static function create($image, string $path, bool $cube, int $quality, bool $strRand = true , int $width = null, int $height = null): string
  {
    $file = $image->getClientOriginalName();
    $destinationPath = public_path($path);
    $originalName = pathinfo($file, PATHINFO_FILENAME);
    if ($strRand) {
      $time = time() . '_';
       $nameNonType = $time . $originalName;
    } else {
      $nameNonType = $originalName;
    }
    foreach (self::$type as $type) {
      $name = $nameNonType . '.' . $type;
      $img = Image::make($image->getRealPath())->encode($type, $quality);
      if ($cube) {
        $img->fit($width, $width, function ($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();
        });
      } else {
        $img->resize($width, $height, function ($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();
        });
      }
      $img->save($destinationPath . '/' . $name);
    }

    return $nameNonType;
  }

  /**
   * Delete Files by name
   *
   * @param string $name
   * @param string $path
   * @param bool $types
   * @return bool
   */
  public static function delete(string $name, string $path, bool $types): bool
  {
    if ($types) {
      foreach (self::$type as $type) {
        if (file_exists(public_path($path . $name . '.' . $type))) {
          File::delete(public_path($path . $name . '.' . $type));
        }
      }
    } else if (file_exists(public_path($path . $name))) {
      File::delete(public_path($path . $name));
    }
    return true;
  }

}
