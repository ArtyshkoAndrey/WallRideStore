<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ModalTranslation
 *
 * @property int $id
 * @property int $modal_id
 * @property string $locale
 * @property string $title
 * @property string|null $description
 * @property string|null $text_to_link
 * @method static Builder|ModalTranslation newModelQuery()
 * @method static Builder|ModalTranslation newQuery()
 * @method static Builder|ModalTranslation query()
 * @method static Builder|ModalTranslation whereDescription($value)
 * @method static Builder|ModalTranslation whereId($value)
 * @method static Builder|ModalTranslation whereLocale($value)
 * @method static Builder|ModalTranslation whereModalId($value)
 * @method static Builder|ModalTranslation whereTextToLink($value)
 * @method static Builder|ModalTranslation whereTitle($value)
 * @mixin Eloquent
 */
class ModalTranslation extends Model
{
  use HasFactory;

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
    'description',
    'text_to_link'
  ];
}
