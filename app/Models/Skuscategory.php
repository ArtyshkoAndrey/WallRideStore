<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Skuscategory
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SkuscategoryTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SkuscategoryTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Skuscategory listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Skuscategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skuscategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skuscategory notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Skuscategory orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Skuscategory orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Skuscategory orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Skuscategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|Skuscategory translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Skuscategory translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Skuscategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skuscategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skuscategory whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Skuscategory whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Skuscategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skuscategory withTranslation()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Skus[] $skuses
 * @property-read int|null $skuses_count
 */
class Skuscategory extends Model implements TranslatableContract
{
  use HasFactory;
  use Translatable;

  public array $translatedAttributes = [
    'name',
  ];

  protected $fillable = [

  ];

  public function skuses (): HasMany
  {
    return $this->hasMany(Skus::class, 'skuscategory_id', 'id');
  }

}
