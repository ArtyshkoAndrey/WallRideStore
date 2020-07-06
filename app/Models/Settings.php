<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
  protected $fillable = ['key', 'meta'];

  protected $casts = ['meta' => 'string', 'key' => 'string'];

  public function statusSite ($status = null) {
    if ($status === null)
      return boolval( $this->where('key', 'status')->first()->meta );
    else
      $this->where('key', 'status')->first()->update(['meta' => $status]);
  }
}
