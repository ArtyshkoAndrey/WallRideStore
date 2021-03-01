<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Brand
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read BrandTranslation|null $translation
 * @property-read Collection|BrandTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|Brand listsTranslations(string $translationField)
 * @method static Builder|Brand newModelQuery()
 * @method static Builder|Brand newQuery()
 * @method static Builder|Brand notTranslatedIn(?string $locale = null)
 * @method static Builder|Brand orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Brand orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Brand orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Brand query()
 * @method static Builder|Brand translated()
 * @method static Builder|Brand translatedIn(?string $locale = null)
 * @method static Builder|Brand whereCreatedAt($value)
 * @method static Builder|Brand whereId($value)
 * @method static Builder|Brand whereName($value)
 * @method static Builder|Brand whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Brand whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Brand whereUpdatedAt($value)
 * @method static Builder|Brand withTranslation()
 * @mixin Eloquent
 * @property string|null $logo
 * @property string|null $photo
 * @property string|null $logo_path
 * @property string|null $photo_path
 * @property bool $to_index
 * @property-read string $logo_jpg_storage
 * @property-read string $logo_webp_storage
 * @property-read string $photo_jpg_storage
 * @property-read string $photo_webp_storage
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static Builder|Brand whereLogo($value)
 * @method static Builder|Brand wherePhoto($value)
 * @method static Builder|Brand whereToIndex($value)
 */
	class Brand extends \Eloquent implements \Astrotomic\Translatable\Contracts\Translatable {}
}

namespace App\Models{
/**
 * App\Models\BrandTranslation
 *
 * @property int $id
 * @property int $brand_id
 * @property string $locale
 * @property string $description
 * @method static Builder|BrandTranslation newModelQuery()
 * @method static Builder|BrandTranslation newQuery()
 * @method static Builder|BrandTranslation query()
 * @method static Builder|BrandTranslation whereBrandId($value)
 * @method static Builder|BrandTranslation whereDescription($value)
 * @method static Builder|BrandTranslation whereId($value)
 * @method static Builder|BrandTranslation whereLocale($value)
 * @mixin Eloquent
 */
	class BrandTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CartItem
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_sku_id
 * @property int $amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Product $product
 * @property-read User $user
 * @method static Builder|CartItem newModelQuery()
 * @method static Builder|CartItem newQuery()
 * @method static Builder|CartItem query()
 * @method static Builder|CartItem whereAmount($value)
 * @method static Builder|CartItem whereCreatedAt($value)
 * @method static Builder|CartItem whereId($value)
 * @method static Builder|CartItem whereProductSkuId($value)
 * @method static Builder|CartItem whereUpdatedAt($value)
 * @method static Builder|CartItem whereUserId($value)
 * @mixin Eloquent
 */
	class CartItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property bool $to_menu
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read CategoryTranslation|null $translation
 * @property-read Collection|CategoryTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|Category listsTranslations(string $translationField)
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category notTranslatedIn(?string $locale = null)
 * @method static Builder|Category orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Category orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Category orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Category query()
 * @method static Builder|Category translated()
 * @method static Builder|Category translatedIn(?string $locale = null)
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereToMenu($value)
 * @method static Builder|Category whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Category whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Category whereUpdatedAt($value)
 * @method static Builder|Category withTranslation()
 * @mixin Eloquent
 * @property string|null $photo
 * @property-read Collection|Category[] $child
 * @property-read int|null $child_count
 * @property-read string $photo_storage
 * @property-read string $search_name
 * @property-read Collection|Category[] $parents
 * @property-read int|null $parents_count
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static Builder|Category wherePhoto($value)
 */
	class Category extends \Eloquent implements \Astrotomic\Translatable\Contracts\Translatable {}
}

namespace App\Models{
/**
 * App\Models\CategoryTranslation
 *
 * @property int $id
 * @property int $category_id
 * @property string $locale
 * @property string $name
 * @method static Builder|CategoryTranslation newModelQuery()
 * @method static Builder|CategoryTranslation newQuery()
 * @method static Builder|CategoryTranslation query()
 * @method static Builder|CategoryTranslation whereCategoryId($value)
 * @method static Builder|CategoryTranslation whereId($value)
 * @method static Builder|CategoryTranslation whereLocale($value)
 * @method static Builder|CategoryTranslation whereName($value)
 * @mixin Eloquent
 */
	class CategoryTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\City
 *
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Country|null $country
 * @method static Builder|City newModelQuery()
 * @method static Builder|City newQuery()
 * @method static Builder|City query()
 * @method static Builder|City whereCountryId($value)
 * @method static Builder|City whereCreatedAt($value)
 * @method static Builder|City whereId($value)
 * @method static Builder|City whereName($value)
 * @method static Builder|City whereUpdatedAt($value)
 * @mixin Eloquent
 * @property bool $pickup
 * @property-read string $search_name
 * @method static Builder|City wherePickup($value)
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Country newModelQuery()
 * @method static Builder|Country newQuery()
 * @method static Builder|Country query()
 * @method static Builder|Country whereCode($value)
 * @method static Builder|Country whereCreatedAt($value)
 * @method static Builder|Country whereId($value)
 * @method static Builder|Country whereName($value)
 * @method static Builder|Country whereUpdatedAt($value)
 * @mixin Eloquent
 */
	class Country extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CouponCode
 *
 * @property int $id
 * @property string $code
 * @property string $type
 * @property string $value
 * @property int $total
 * @property int $used
 * @property string $min_amount
 * @property string $max_amount
 * @property bool $disabled_other_sales
 * @property Carbon $not_before
 * @property Carbon $not_after
 * @property bool $enabled
 * @property bool $notification
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $description
 * @method static Builder|CouponCode newModelQuery()
 * @method static Builder|CouponCode newQuery()
 * @method static Builder|CouponCode query()
 * @method static Builder|CouponCode whereCode($value)
 * @method static Builder|CouponCode whereCreatedAt($value)
 * @method static Builder|CouponCode whereDisabledOtherSales($value)
 * @method static Builder|CouponCode whereEnabled($value)
 * @method static Builder|CouponCode whereId($value)
 * @method static Builder|CouponCode whereMaxAmount($value)
 * @method static Builder|CouponCode whereMinAmount($value)
 * @method static Builder|CouponCode whereNotAfter($value)
 * @method static Builder|CouponCode whereNotBefore($value)
 * @method static Builder|CouponCode whereNotification($value)
 * @method static Builder|CouponCode whereTotal($value)
 * @method static Builder|CouponCode whereType($value)
 * @method static Builder|CouponCode whereUpdatedAt($value)
 * @method static Builder|CouponCode whereUsed($value)
 * @method static Builder|CouponCode whereValue($value)
 * @mixin Eloquent
 * @property-read Collection|Brand[] $brandsDisabled
 * @property-read int|null $brands_disabled_count
 * @property-read Collection|Brand[] $brandsEnabled
 * @property-read int|null $brands_enabled_count
 * @property-read Collection|Category[] $categoriesDisabled
 * @property-read int|null $categories_disabled_count
 * @property-read Collection|Category[] $categoriesEnabled
 * @property-read int|null $categories_enabled_count
 * @property-read Collection|Product[] $productsDisabled
 * @property-read int|null $products_disabled_count
 * @property-read Collection|Product[] $productsEnabled
 * @property-read int|null $products_enabled_count
 */
	class CouponCode extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Currency
 *
 * @property int $id
 * @property string $name
 * @property float $ratio
 * @property string $symbol
 * @property string $short_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereRatio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereSymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Currency extends \Eloquent {}
}

namespace App\Models{
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
 */
	class Faqs extends \Eloquent implements \Astrotomic\Translatable\Contracts\Translatable {}
}

namespace App\Models{
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
	class FaqsTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $no
 * @property int $user_id
 * @property object $address
 * @property string $price
 * @property string $ship_price
 * @property Carbon|null $paid_at
 * @property string $payment_method
 * @property string $ship_status
 * @property object|null $ship_data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $coupon_code_id
 * @property string $sale
 * @property string $transfer
 * @property-read Collection|OrderItem[] $items
 * @property-read int|null $items_count
 * @property-read User $user
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereAddress($value)
 * @method static Builder|Order whereCouponCodeId($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereNo($value)
 * @method static Builder|Order wherePaidAt($value)
 * @method static Builder|Order wherePaymentMethod($value)
 * @method static Builder|Order wherePrice($value)
 * @method static Builder|Order whereSale($value)
 * @method static Builder|Order whereShipData($value)
 * @method static Builder|Order whereShipPrice($value)
 * @method static Builder|Order whereShipStatus($value)
 * @method static Builder|Order whereTransfer($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order whereUserId($value)
 * @mixin Eloquent
 * @property-read CouponCode|null $couponCode
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderItem
 *
 * @property int $id
 * @property int $product_id
 * @property int $order_id
 * @property int $skus_id
 * @property int $amount
 * @property string $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Order $order
 * @property-read Product $product
 * @property-read Skus $skus
 * @method static Builder|OrderItem newModelQuery()
 * @method static Builder|OrderItem newQuery()
 * @method static Builder|OrderItem query()
 * @method static Builder|OrderItem whereAmount($value)
 * @method static Builder|OrderItem whereCreatedAt($value)
 * @method static Builder|OrderItem whereId($value)
 * @method static Builder|OrderItem whereOrderId($value)
 * @method static Builder|OrderItem wherePrice($value)
 * @method static Builder|OrderItem whereProductId($value)
 * @method static Builder|OrderItem whereSkusId($value)
 * @method static Builder|OrderItem whereUpdatedAt($value)
 * @mixin Eloquent
 */
	class OrderItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Photo
 *
 * @property int $id
 * @property int|null $product_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $thumbnail_url_jpg
 * @property-read string $thumbnail_url_webp
 * @property-read string $url_jpg
 * @property-read string $url_webp
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Photo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $photo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Post extends \Eloquent {}
}

namespace App\Models{
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
	class PostTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property bool $on_sale
 * @property bool $on_new
 * @property bool $on_top
 * @property int $sold_count
 * @property string $price
 * @property string|null $price_sale
 * @property string $weight
 * @property object $meta
 * @property int|null $brand_id
 * @property int|null $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\ProductTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Product translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOnNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOnSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOnTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePriceSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSoldCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @metphod static \Illuminate\Database\Eloquent\Builder|Product whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product withTranslation()
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Models\Brand|null $brand
 * @property-read \App\Models\Category|null $category
 * @property-read string $thumbnail_jpg
 * @property-read string $thumbnail_webp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Photo[] $photos
 * @property-read int|null $photos_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductSkus[] $productSkuses
 * @property-read int|null $product_skuses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Skus[] $skuses
 * @property-read int|null $skuses_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTranslationLike(string $translationField, $value, ?string $locale = null)
 */
	class Product extends \Eloquent implements \Astrotomic\Translatable\Contracts\Translatable {}
}

namespace App\Models{
/**
 * App\Models\ProductSkus
 *
 * @property int $id
 * @property int $stock
 * @property int $product_id
 * @property int $skus_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Skus|null $skus
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkus query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkus whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkus whereSkusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkus whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSkus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ProductSkus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductTranslation
 *
 * @property int $id
 * @property int $product_id
 * @property string $locale
 * @property string $title
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTranslation whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTranslation whereTitle($value)
 * @mixin \Eloquent
 */
	class ProductTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $name
 * @property string $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Skus
 *
 * @property int $id
 * @property string $title
 * @property int $weight
 * @property int $skuscategory_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Skuscategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Skus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skus query()
 * @method static \Illuminate\Database\Eloquent\Builder|Skus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skus whereSkuscategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skus whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skus whereWeight($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductSkus[] $productSkus
 * @property-read int|null $product_skus_count
 */
	class Skus extends \Eloquent {}
}

namespace App\Models{
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
	class Skuscategory extends \Eloquent implements \Astrotomic\Translatable\Contracts\Translatable {}
}

namespace App\Models{
/**
 * App\Models\SkuscategoryTranslation
 *
 * @property int $id
 * @property int $skuscategory_id
 * @property string $locale
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|SkuscategoryTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkuscategoryTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkuscategoryTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|SkuscategoryTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkuscategoryTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkuscategoryTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkuscategoryTranslation whereSkuscategoryId($value)
 * @mixin \Eloquent
 */
	class SkuscategoryTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Slider
 *
 * @property int $id
 * @property string $url
 * @property string $mobile_text
 * @property string $photo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $photo_mobile_url
 * @property-read string $photo_url
 * @property-read \App\Models\SliderTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SliderTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Slider listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Slider query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereMobileText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider withTranslation()
 * @mixin \Eloquent
 */
	class Slider extends \Eloquent implements \Astrotomic\Translatable\Contracts\Translatable {}
}

namespace App\Models{
/**
 * App\Models\SliderTranslation
 *
 * @property int $id
 * @property int $slider_id
 * @property string $locale
 * @property string $h1
 * @property string $h2
 * @property string $btn_text
 * @method static \Illuminate\Database\Eloquent\Builder|SliderTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SliderTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SliderTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|SliderTranslation whereBtnText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderTranslation whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderTranslation whereH2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderTranslation whereSliderId($value)
 * @mixin \Eloquent
 */
	class SliderTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $avatar
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $address
 * @property string|null $post_code
 * @property string|null $phone
 * @property bool $notification
 * @property bool $old_notification
 * @property int|null $currency_id
 * @property bool $is_admin
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\City $city
 * @property-read \App\Models\Country $country
 * @property-read \App\Models\Currency|null $currency
 * @property-read string $user_image
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAddress($value)
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereCurrencyId($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIsAdmin($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User whereNotification($value)
 * @method static Builder|User whereOldNotification($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User wherePostCode($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CartItem[] $cartItems
 * @property-read int|null $cart_items_count
 * @property-read string $full_address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 */
	class User extends \Eloquent {}
}

