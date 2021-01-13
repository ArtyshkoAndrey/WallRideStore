<?php

namespace App\Services;

use Intervention\Image\Exception\NotWritableException;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

/**
 * Class PhotoService Для работы с фотографиями
 * @package App\Services
 */
class PhotoService
{

  /**
   * Измененеие размера фотографии
   * @param $file
   * @param int|null $width
   * @param int|null $height
   * @param bool $box
   * @return \Intervention\Image\Image
   */
  public function resize ($file, bool $box = false ,int $width = null, int $height = null) : \Intervention\Image\Image
  {
    $img = Image::make($file->getRealPath())->encode('jpg', 80);

    if ($box) {
      $img->fit($width ?? $height ?? 600);
    } else {
      $img->resize($width, $height, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
      });
    }
    return $img;
  }

  /**
   * Сохранение фотографии по параметрам
   * @param $file
   * @param string $path
   * @param bool $box
   * @param int|null $width
   * @param int|null $height
   * @param string|null $name
   * @return string
   */
  public function create ($file, string $path, bool $box = false, int $width = null, int $height = null, string $name = null) : string
  {

    try {
      $name = $name ? $name . '.jpg' : pathinfo($file, PATHINFO_FILENAME) . '_' . microtime() . '.jpg';
      $this->resize($file, $box, $width, $height)
        ->save($path . '/' . $name);
      return $name;
    } catch (NotWritableException $e) {
      return redirect()->back()->withErrors(['Ошибка сохранения фотографии']);
    }
  }

  public function delete(string $path) : bool
  {
    return File::delete($path);
  }
}
