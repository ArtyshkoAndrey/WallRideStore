<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\FaceBookController;
use App\Http\Controllers\Api\ModalController;
use App\Http\Controllers\Api\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

Route::post('countries', [App\Http\Controllers\ApiController::class, 'countries'])->name('api.countries');
Route::post('cities', [App\Http\Controllers\ApiController::class, 'cities'])->name('api.cities');
Route::post('categories', [App\Http\Controllers\ApiController::class, 'categories']);
Route::post('brands', [App\Http\Controllers\ApiController::class, 'brands']);

Route::post('currency/{id}', [ApiController::class, 'currency']);
Route::post('set-currency', [ApiController::class, 'set_currency']);
Route::post('products', [ApiController::class, 'products']);
Route::post('update-cart', [ApiController::class, 'update_cart']);
Route::post('cart-items-auth', [ApiController::class, 'cart_items_auth']);

Route::post('coupon', [ApiController::class, 'coupon']);

Route::post('cost-ems', [ApiController::class, 'getCostEms']);
Route::post('companies', [ApiController::class, 'companies']);
Route::get('modals', [ModalController::class, 'index']);
Route::get('modals/code', [ModalController::class, 'code']);
Route::get('cost-ems-test', [ApiController::class, 'getCostEmsTest']);
Route::post('/notification', [NotificationController::class, 'updateUserNotification']);
//Route::get('get/products', [ApiController::class, 'parser']);

Route::get('/facebook/items', [FaceBookController::class, 'items']);
