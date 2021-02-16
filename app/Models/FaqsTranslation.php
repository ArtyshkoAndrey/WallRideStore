<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FaqsTranslation
 *
 * @property int $id
 * @property int $faqs_id
 * @property string $locale
 * @property string $title
 * @property string $content
 * @method static Builder|FaqsTranslation newModelQuery()
 * @method static Builder|FaqsTranslation newQuery()
 * @method static Builder|FaqsTranslation query()
 * @method static Builder|FaqsTranslation whereContent($value)
 * @method static Builder|FaqsTranslation whereFaqsId($value)
 * @method static Builder|FaqsTranslation whereId($value)
 * @method static Builder|FaqsTranslation whereLocale($value)
 * @method static Builder|FaqsTranslation whereTitle($value)
 * @mixin Eloquent
 */
class FaqsTranslation extends Model
{
  /**
   * Not use Date
   *
   * @var bool
   */
  public $timestamps = false;

  /**
   * Columns
   *
   * @var string[]
   */
  protected $fillable = [
    'title',
    'content'
  ];
}
