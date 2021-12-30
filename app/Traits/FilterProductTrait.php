<?php

namespace App\Traits;

use App\Exceptions\RedirectWithErrorsException;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Skus;
use Validator;

trait FilterProductTrait
{

  /**
   * @param array $brands
   * @param array $categories
   * @param string $order
   * @param array $sizes
   * @param bool $sale
   * @param bool $new
   * @param int $paginate
   * @return array
   * @throws RedirectWithErrorsException
   */
  public function filter(array $brands, array $categories, string $order, array $sizes, int $paginate, bool $sale = null, bool $new = null): array
  {

    $items = Product::query();

    if ($sale) {
      $items = $items->whereOnSale(true);
    }

    if ($new) {
      $items = $items->whereOnNew(true);
    }

    if ($order === 'sort-new') {
      $items = $items->orderBy('created_at', 'desc');
    } else if ($order === 'sort-old') {
      $items = $items->orderBy('created_at');
    } else if ($order === 'sort-expensive') {
      $items = $items->orderBy('price', 'desc');
    } else if ($order === 'sort-cheap') {
      $items = $items->orderBy('price');
    }

    $rules = [
      'categories' => 'sometimes|array',
      'categories.*' => 'exists:categories,id', // check each item in the array
    ];
    $validator = Validator::make(['categories' => $categories], $rules);
    if ($validator->fails()) {
      throw new RedirectWithErrorsException(__('errors_redirect.product.product_catalog_categories'));
    }

    foreach ($categories as $index => $category) {
      if ($index === 0) {
        $items->whereHas('category', function ($query) use ($category) {
          $query->whereHas('parents', function ($query) use ($category) {
            $query->where('laravel_reserved_0.id', $category);
          })
            ->orWhere('categories.id', $category);
        });
      } else {
        $items = $items->orWhereHas('category', function ($query) use ($category, $index) {
          $query->whereHas('parents', function ($query) use ($category, $index) {
            $query->where('laravel_reserved_' . $index . '.id', $category);
          })
            ->orWhere('categories.id', $category);
        });
      }
    }

    $rules = [
      'brands' => 'sometimes|array',
      'brands.*' => 'exists:brands,id', // check each item in the array
    ];
    $validator = Validator::make(['brands' => $brands], $rules);
    if ($validator->fails()) {
      throw new RedirectWithErrorsException(__('errors_redirect.product.product_catalog_brands'));
    }

    foreach ($brands as $index => $brand) {
      if ($index == 0) {
        $items = $items->whereHas('brand', function ($query) use ($brand) {
          return $query->where('brands.id', '=', $brand);
        });
      } else {
        $items = $items->orWhereHas('brand', function ($query) use ($brand) {
          return $query->where('brands.id', '=', $brand)->with('productSkuses')->orderBy('weight');
        });

      }

    }

//    TODO: Когданить исправить на нормальный запросы
    if ($brands !== [] && $categories !== []) {
      $attributes = Skus::whereHas('products.brand', function ($q) use ($brands) {
        $q->whereIn('products.brand_id', $brands);
      })
        ->whereHas('products.category', function ($q) use ($categories) {
          $q->whereIn('products.category_id', $categories);
        })->get();
    } else if ($categories !== [] && $brands === []) {
      $attributes = Skus::whereHas('products.category', function ($q) use ($categories) {
        $q->whereIn('products.category_id', $categories);
      })->get();
    } else if ($categories === [] && $brands !== []) {
      $attributes = Skus::whereHas('products.brand', function ($q) use ($brands) {
        $q->whereIn('products.brand_id', $brands);
      })->get();
    } else {
      $attributes = Skus::all();
    }

    $rules = [
      'skuses' => 'sometimes|array',
      'skuses.*' => 'exists:skuses,id', // check each item in the array
    ];
    $validator = Validator::make(['skuses' => $sizes], $rules);
    if ($validator->fails()) {
      throw new RedirectWithErrorsException(__('errors_redirect.product.product_catalog_skuses'));
    }
    if (!empty($sizes)) {
      $items = $items->whereHas('skuses', function ($query) use ($sizes) {
        return $query->whereIn('skus_id', $sizes)->with('productSkuses')->orderBy('weight');
      });

    }

    $itemsCount = $items->count();
    $items = $items->paginate($paginate);
    $filter = [
      'category' => $categories,
      'order' => $order,
      'brand' => $brands,
      'sale' => $sale,
      'new' => $new,
      'size' => $sizes
    ];
    $counter = 0;
    foreach ($filter as $name => $f) {
      if ($name !== 'sale' && $name !== 'new' && $name !== 'order') {
        $counter += count($f);
      } else {
        if ($f && $name !== 'order') {
          $counter++;
        }
      }
    }
    if ($categories !== []) {
      $brandsCollection = Brand::whereHas('products.category', function ($q) use ($categories) {
        $q->whereIn('products.category_id', $categories);
      })->get();
    } else {
      $brandsCollection = Brand::all();
    }


    return [
      'items' => $items,
      'filter' => $filter,
      'counter' => $counter,
      'itemsCount' => $itemsCount,
      'attributes' => $attributes,
      'brands' => $brandsCollection
    ];
  }
}
