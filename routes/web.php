<?php

use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ModalController;
use App\Http\Controllers\Admin\PickupController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Auth::routes();

// Admin Controllers

Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
  Route::get('/', [HomeController::class, 'index'])->name('index');

  Route::get('/redirect', [HomeController::class, 'redirect'])->name('redirect');

  Route::resource('order', App\Http\Controllers\Admin\OrderController::class)->except([
    'create', 'store', 'show'
  ]);

  Route::resource('product', App\Http\Controllers\Admin\ProductController::class)->except([
    'show'
  ]);

  Route::resource('skus', App\Http\Controllers\Admin\SkusController::class)->except([
    'create'
  ]);

  Route::resource('express', App\Http\Controllers\Admin\ExpressController::class)->except([
    'show'
  ]);

  Route::resource('express-zone', App\Http\Controllers\Admin\ExpressZoneController::class)->except([
    'show'
  ]);

  Route::post('/express-zone/{id}/destroy', [App\Http\Controllers\Admin\ExpressZoneController::class, 'destroyCity'])->name('express-zone.destroyCity');

  Route::resource('skus-category', App\Http\Controllers\Admin\SkusCategoryController::class)->only([
    'store', 'destroy'
  ]);

  Route::resource('brand', App\Http\Controllers\Admin\BrandController::class)->except([
    'create', 'show', 'edit'
  ]);

  Route::resource('category', App\Http\Controllers\Admin\CategoryController::class)->except([
    'create', 'show', 'edit'
  ]);

  Route::resource('coupon', App\Http\Controllers\Admin\CouponController::class)->except([
    'show'
  ]);

  Route::resource('post', PostController::class)->except([
    'show'
  ]);

  Route::resource('modal', ModalController::class)->except([
    'show'
  ]);
  Route::post('modal/photo/store', [ModalController::class, 'photo_store'])->name('modal.photo.store');
  Route::post('modal/photo/delete', [ModalController::class, 'photo_delete'])->name('modal.photo.delete');

  Route::post('post/content-image', [PostController::class, 'content_mage'])->name('post.content-image');
  Route::post('post/photo/store', [PostController::class, 'photo_store'])->name('post.photo.store');
  Route::post('post/photo/delete', [PostController::class, 'photo_delete'])->name('post.photo.delete');

  Route::resource('slider', App\Http\Controllers\Admin\SliderController::class)->except([
    'show'
  ]);
  Route::post('slider/photo/store', [SliderController::class, 'photo_store'])->name('slider.photo.store');
  Route::post('slider/photo/delete', [SliderController::class, 'photo_delete'])->name('slider.photo.delete');

  Route::resource('faq', App\Http\Controllers\Admin\FAQController::class)->except([
    'show'
  ]);
  Route::post('faq/content-image', [FAQController::class, 'content_mage'])->name('faq.content-image');
  Route::post('faq/photo/store', [FAQController::class, 'photo_store'])->name('faq.photo.store');
  Route::post('faq/photo/delete', [FAQController::class, 'photo_delete'])->name('faq.photo.delete');

  Route::resource('notification', App\Http\Controllers\Admin\NotificationController::class)->only([
    'index', 'store'
  ]);

  Route::post('product/photo/store', [\App\Http\Controllers\Admin\ProductController::class, 'photoStore'])->name('product.store.photo');
  Route::post('product/photo/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'photo'])->name('product.photo');
  Route::post('product/photo-delete', [\App\Http\Controllers\Admin\ProductController::class, 'photoDelete'])->name('product.photo.delete');

  Route::prefix('settings')->name('settings.')->group(function () {
    Route::prefix('pickup')->name('pickup.')->group(function () {
      Route::get('/', [PickupController::class, 'index'])->name('index');
      Route::post('/store', [PickupController::class, 'store'])->name('store');
      Route::delete('/{id}', [PickupController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('money')->name('money.')->group(function () {
      Route::get('/', [SettingController::class, 'index'])->name('index');
      Route::put('/', [SettingController::class, 'update'])->name('update');
    });
  });
});

if (config('app.unstable', false)) {
  Route::get('{path}', function () {
    return view('user.layouts.error');
  })->where('path', '(.*)');
}

// User

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::get('language/change/{locale}', [\App\Http\Controllers\HomeController::class, 'language']);
Route::get('policy', [\App\Http\Controllers\HomeController::class, 'policy'])->name('policy');
Route::post('auth/check', [App\Http\Controllers\ApiController::class, 'check']);


Route::prefix('product')->name('product.')->group(function () {
  Route::get('/search', [ProductController::class, 'search'])->name('search');
  Route::get('/all', [ProductController::class, 'all'])->name('all');
  Route::get('/favor', [ProductController::class, 'favor'])->name('favor');
  Route::get('/{id}', [ProductController::class, 'show'])->name('show');
});

Route::resource('brand', App\Http\Controllers\BrandController::class)->only(['show']);

Route::prefix('cart')->name('cart.')->group(function () {
  Route::get('/', [CartController::class, 'index'])->name('index');
});

Route::resource('post', App\Http\Controllers\PostController::class)->only(['show', 'index']);
Route::resource('faq', App\Http\Controllers\FaqController::class)->only(['show', 'index']);

Route::middleware(['auth'])->prefix('profile')->name('profile.')->group(function () {
  Route::name('update.')->prefix('update')->group(function () {
    Route::put('data', [ProfileController::class, 'data'])->name('data');
    Route::put('photo', [ProfileController::class, 'photo'])->name('photo');
    Route::put('password', [ProfileController::class, 'password'])->name('password');
  });
  Route::get('/', [ProfileController::class, 'index'])->name('index');
  Route::get('notification/subscribe', [ProfileController::class, 'subscribe'])->name('notification.subscribe');
  Route::get('notification/unsubscribe', [ProfileController::class, 'unsubscribe'])->name('notification.unsubscribe');
});
Route::get('notification/unsubscribe-email', [ProfileController::class, 'unsubscribeEmail'])->name('profile.notification.unsubscribe.email');

Route::prefix('order')->name('order.')->group(function () {
  Route::get('/', [OrderController::class, 'index'])->middleware('auth')->name('index');
  Route::get('/create', [OrderController::class, 'create'])->name('create');
  Route::post('/store', [OrderController::class, 'store'])->name('store');
  Route::post('/update/status', [OrderController::class, 'updateStatus'])->name('update.status');
});
