<?php

namespace App\Jobs;

use App\Models\Photo;
use App\Services\PhotoService;
use Ds\Set;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

// Работа отчистки хостинга от лишних фотографий
class ClearImages implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public function __construct()
  {

  }

  public function handle(): void
  {
    $dir = public_path(Photo::PHOTO_PATH);

    $files = array_values(array_filter(scandir($dir), static function ($file) use ($dir) {
      return !is_dir($dir . '/' . $file);
    }));
    $filesName = new Set();
    foreach ($files as $file) {
      if (file_exists($dir . '/' . $file)) {
        $userFile = new File($dir . '/' . $file);
        $filename = explode($userFile->getExtension(), $userFile->getBasename())[0];
        $filename = explode('.', $filename)[0];

        if (!$filesName->contains($filename)) {
          $filesName->add($filename);

          if (!Photo::whereName($filename)->exists()) {
            PhotoService::delete($filename, Photo::PHOTO_PATH, true);
          }
        } else {
          continue;
        }
      }

    }
  }
}
