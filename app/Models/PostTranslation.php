<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PostTranslation
 *
 * @property int $id
 * @property int $post_id
 * @property string $locale
 * @property string $title
 * @property string $content
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class PostTranslation extends Model
{
  public $timestamps = false;

  protected $fillable = [
    'title',
    'description'
  ];
}
