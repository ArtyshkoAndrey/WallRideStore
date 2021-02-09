<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FaqsTranslation
 *
 * @property int $id
 * @property int $faqs_id
 * @property string $locale
 * @property string $title
 * @property string $content
 * @method static \Illuminate\Database\Eloquent\Builder|FaqsTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FaqsTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FaqsTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|FaqsTranslation whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqsTranslation whereFaqsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqsTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqsTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqsTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class FaqsTranslation extends Model
{
  public $timestamps = false;

  protected $fillable = [
    'title', 'content',
  ];
}
