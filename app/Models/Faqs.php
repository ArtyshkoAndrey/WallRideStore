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
 * App\Models\Faqs
 *
 * @property int $id
 * @property string $image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read FaqsTranslation|null $translation
 * @property-read Collection|FaqsTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|Faqs listsTranslations(string $translationField)
 * @method static Builder|Faqs newModelQuery()
 * @method static Builder|Faqs newQuery()
 * @method static Builder|Faqs notTranslatedIn(?string $locale = null)
 * @method static Builder|Faqs orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Faqs orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Faqs orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Faqs query()
 * @method static Builder|Faqs translated()
 * @method static Builder|Faqs translatedIn(?string $locale = null)
 * @method static Builder|Faqs whereCreatedAt($value)
 * @method static Builder|Faqs whereId($value)
 * @method static Builder|Faqs whereImage($value)
 * @method static Builder|Faqs whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Faqs whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Faqs whereUpdatedAt($value)
 * @method static Builder|Faqs withTranslation()
 * @mixin Eloquent
 * @property-read string $photo_storage
 * @property-read string $photo_storage_jpg
 * @property-read string $photo_storage_webp
 */
class Faqs extends Model implements TranslatableContract
{
  use HasFactory;
  use Translatable;

  /**
   * Translate Columns
   *
   * @var array|string[]
   */
  public array $translatedAttributes = [
    'title',
    'content'
  ];

  /**
   * Columns
   *
   * @var string[]
   */
  protected $fillable = [
    'image'
  ];

  const PHOTO_PATH = 'storage/faqs/photo/';
  const PHOTO_CONTENT_PATH = 'storage/faqs/content/';

  public function getPhotoStorageJpgAttribute(): string
  {
    if ($this->image) {
      return asset(Faqs::PHOTO_PATH . $this->image . '.jpg');
    }
    return asset('images/user-o.jpg');
  }

  public function getPhotoStorageWebpAttribute(): string
  {
    if ($this->image) {
      return asset(Faqs::PHOTO_PATH . $this->image . '.webp');
    }
    return asset('images/user-o.jpg');
  }
}
