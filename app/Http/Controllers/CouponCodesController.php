<?php

namespace App\Http\Controllers;

use App\Exceptions\CouponCodeUnavailableException;
use App\Models\CouponCode;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponCodesController extends Controller
{
    public function show($code, Request $request)
    {
      if (!$record = CouponCode::where('code', $code)->first()) {
        throw new CouponCodeUnavailableException('Данного купона не существует');
      }

      if ($record->notification && Auth::check()) {
        if (!auth()->user()->notification) {
          throw new CouponCodeUnavailableException('Купон распотроняется только пользователей с подпиской на рассылку новостей');
        }
      } elseif ($record->notification && !Auth::check()) {
        throw new CouponCodeUnavailableException('Необходимо войти в аккаунт для использования данныного промокода');
      }

      $record->checkAvailable();
      $items = $request->items;
      foreach ($items as $item) {
        $pr = Product::find($item['productSku']['product']['id']);
        $countBrandsEnabled = $record->brandsEnabled()->count();
        $countProductsEnabled = $record->productsEnabled()->count();
        $countCategoriesEnabled = $record->categoriesEnabled()->count();
        if ($record->productsDisabled()->where('product_id', $pr->id)->exists()) {
          throw new CouponCodeUnavailableException('Купон не распространяеться на данный товар: ' . $item['productSku']['product']['title']);
        }
        if ($record->brandsDisabled()->whereIn('brand_id', $pr->brands)->exists()) {
          throw new CouponCodeUnavailableException('Купон не распространяеться на бренд товара: ' . $item['productSku']['product']['title']);
        }

        if ($record->categoriesDisabled()->whereIn('category_id', $pr->categories)->exists()) {
          throw new CouponCodeUnavailableException('Купон не распространяеться на категорию товара: ' . $item['productSku']['product']['title']);
        }

        if ($countBrandsEnabled > 0) {
          if (!$record->brandsEnabled()->whereIn('brand_id', $pr->brands)->exists()) {
            $msg = '';
            foreach($record->brandsEnabled()->get() as $br) {
              $msg .= $br->name . ', ';
            }
            throw new CouponCodeUnavailableException('Купон распространяеться только на бренд(ы): ' . $msg);
          }
        }
        if ($countProductsEnabled > 0) {
          if (!$record->productsEnabled()->where('product_id', $pr->id)->exists()) {
            $msg = '';
            foreach($record->productsEnabled()->get() as $br) {
              $msg .= ucfirst(strtolower($br->title)). ', ';
            }
            throw new CouponCodeUnavailableException('Купон распространяеться только на товар(ы): ' . $msg);
          }
        }

        if ($countCategoriesEnabled > 0) {
          if (!$record->categoriesEnabled()->whereIn('category_id', $pr->categories)->exists()) {
            $msg = '';
            foreach($record->categoriesEnabled()->get() as $ct) {
              $msg .= $ct->name . ', ';
            }
            throw new CouponCodeUnavailableException('Купон распространяеться только на категории: ' . $msg);
          }
        }
      }
      return ['record' => $record, 'totalAmount' => (int) $record->getAdjustedPrice($request->items)];
    }
}
