<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $photo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post query()
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post wherePhoto($value)
 * @method static Builder|Post whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|Post listsTranslations(string $translationField)
 * @method static Builder|Post notTranslatedIn(?string $locale = null)
 * @method static Builder|Post orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Post orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Post orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Post translated()
 * @method static Builder|Post translatedIn(?string $locale = null)
 * @method static Builder|Post whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Post whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Post withTranslation()
 * @property-read string $photo_storage
 * @property-read PostTranslation|null $translation
 * @property-read Collection|PostTranslation[] $translations
 * @property-read int|null $translations_count
 */
class Post extends Model implements TranslatableContract
{
  use HasFactory;
  use Translatable;

  const PHOTO_PATH = 'storage/posts/photo/';
  const PHOTO_CONTENT_PATH = 'storage/posts/content/';

  public array $translatedAttributes = [
    'title',
    'content',
    'short_content'
  ];
  protected $fillable = [
    'photo'
  ];

  public function getPhotoStorageJpgAttribute(): string
  {
    if ($this->photo) {
      return asset(Post::PHOTO_PATH . $this->photo . '.jpg');
    }
    return asset('images/user-o.jpg');
  }

}
