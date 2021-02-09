<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

/**
 * App\Models\Faqs
 *
 * @property int $id
 * @property string $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FaqsTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FaqsTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Faqs listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Faqs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Faqs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Faqs notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Faqs orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Faqs orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Faqs orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Faqs query()
 * @method static \Illuminate\Database\Eloquent\Builder|Faqs translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Faqs translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Faqs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faqs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faqs whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faqs whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Faqs whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Faqs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faqs withTranslation()
 * @mixin \Eloquent
 */
class Faqs extends Model implements TranslatableContract
{
  use HasFactory;
  use Translatable;

  public array $translatedAttributes = [
    'title', 'content',
  ];

  protected $fillable = [
    'image'
  ];
}
