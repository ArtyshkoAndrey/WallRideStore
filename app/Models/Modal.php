<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Carbon;

/**
 * App\Models\Modal
 *
 * @property int $id
 * @property string $type
 * @property string|null $image
 * @property string|null $link
 * @property bool $status
 * @property bool $on_auth
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ModalTranslation|null $translation
 * @property-read Collection|ModalTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|Modal listsTranslations(string $translationField)
 * @method static Builder|Modal newModelQuery()
 * @method static Builder|Modal newQuery()
 * @method static Builder|Modal notTranslatedIn(?string $locale = null)
 * @method static Builder|Modal orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Modal orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Modal orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Modal query()
 * @method static Builder|Modal translated()
 * @method static Builder|Modal translatedIn(?string $locale = null)
 * @method static Builder|Modal whereCreatedAt($value)
 * @method static Builder|Modal whereId($value)
 * @method static Builder|Modal whereImage($value)
 * @method static Builder|Modal whereLink($value)
 * @method static Builder|Modal whereOnAuth($value)
 * @method static Builder|Modal whereStatus($value)
 * @method static Builder|Modal whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Modal whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Modal whereType($value)
 * @method static Builder|Modal whereUpdatedAt($value)
 * @method static Builder|Modal withTranslation()
 * @mixin Eloquent
 */
class Modal extends Model implements TranslatableContract
{
  use HasFactory;
  use Translatable;

  /**
   * @var string[]
   */
  protected $fillable = [
    'type',
    'image',
    'link',
    'status',
    'on_auth'
  ];

  /**
   * @var string[]
   */
  protected $casts = [
    'on_auth' => 'boolean',
    'status' => 'boolean'
  ];

  /**
   * Translate Columns
   *
   * @var string[]
   */
  public array $translatedAttributes = [
    'title',
    'description',
    'text_to_link'
  ];

  public $appends = [
    'photo_jpg_storage'
  ];

  public const PHOTO_PATH = 'storage/modals/photo/';

  /**
   * Photo jpg type
   *
   * @return string
   */
  public function getPhotoJpgStorageAttribute (): string
  {
    if ($this->image) {
      return asset(self::PHOTO_PATH . $this->image . '.jpg');
    }

    return asset('images/product.jpg');
  }

  /**
   * Photo webp type
   *
   * @return string
   */
  public function getPhotoWebpStorageAttribute (): string
  {
    if ($this->image) {
      return asset(self::PHOTO_PATH . $this->image . '.webp');
    }

    return asset('images/product.jpg');
  }
}
