<?php
// Для всех
use App\Models\Product;
//

if ((new App\Models\Settings)->statusSite()) {

  Route::redirect('/products', '/')->name('root'); // Главаня
  Route::get('/', 'ProductsController@index')->name('products.index'); // Главная с товарами

  Route::get('/about', 'PagesController@about')->name('about'); // О нас
  Route::get('/contact', 'PagesController@contact')->name('contact'); // Контакты

  Route::get('products/all', 'ProductsController@all')->name('products.all');
  Route::get('products/all-sale', 'ProductsController@allsale')->name('products.allsale');
  Route::get('products/all-actions', 'ProductsController@allactions')->name('products.allactions');
  Route::get('products/search', 'ProductsController@search')->name('products.search'); // Главная с товарами
  Route::get('product/{product}', 'ProductsController@show')->name('products.show');
  Route::get('policy', 'PagesController@policy')->name('policy');
  Route::get('location/{city}', ['as' => 'location', 'uses' => 'PagesController@location']);
  Route::resource('news', 'NewsController')->except([
    'edit', 'create', 'destroy', 'update'
  ]);
  Route::resource('faqs', 'FAQController')->except([
    'edit', 'create', 'destroy', 'update'
  ]);

  Route::post('cart', 'CartController@add')->name('cart.add');
  Route::post('cart/minus', 'CartController@minus')->name('cart.minus');
  Route::post('cart/getData', 'CartController@getData')->name('cart.getData');
  Route::get('cart', 'CartController@index')->name('cart.index');
  Route::delete('cart/{sku}', 'CartController@remove')->name('cart.remove');

  Route::get('orders/create', 'OrdersController@create')->name('orders.create');
  Route::post('orders', 'OrdersController@store')->name('orders.store');
  Route::post('orders/success/{no}', 'OrdersController@success')->name('orders.success');
  Route::post('coupon_codes/{code}', 'CouponCodesController@show')->name('coupon_codes.show');
  Auth::routes();


  // Только для авторизированный пользователей
  Route::group(['middleware' => ['auth']], function () {
    Route::resource('profile', 'ProfileController')->except([
      'edit', 'create', 'destroy', 'show', 'create'
    ]);
    Route::post('products/{product}/favorite', 'ProductsController@favor')->name('products.favor');
    Route::delete('products/{product}/favorite', 'ProductsController@disfavor')->name('products.disfavor');
    Route::get('products/favorites', 'ProductsController@allfavor')->name('products.favorites');
    Route::get('orders', 'OrdersController@index')->name('orders.index');
  });
  getAdminRoute();
} else {
  getAdminRoute();
  Route::any('{all}', function () {
    return view('pages.site');
  })->where('all', '.*');
}
function getAdminRoute() {
  Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('login', ['as' => 'admin.auth.login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('login', ['as' => 'admin.auth.login', 'uses' => 'Auth\LoginController@login']);
    // Password Reset Routes...
    Route::post('password/email', ['as' => 'admin.auth.password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/email', ['as' => 'admin.auth.password.email', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/reset', ['as' => 'admin.auth.password.reset', 'uses' => 'Auth\ResetPasswordController@reset']);
    Route::get('password/reset/{token?}', ['as' => 'admin.auth.password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
  });

  Route::group(['prefix' => 'admin', 'guard' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth:admin']], function () {
    Route::get('logout', 'Auth\LoginController@logout')->name('admin.auth.logout');
    Route::delete('/order/all', 'OrderController@collectionsDestroy')->name('admin.store.order.collectionsDestroy');
    Route::delete('/coupon/all', 'CouponCodesController@collectionsDestroy')->name('admin.store.coupon.collectionsDestroy');
    Route::delete('/attr/all', 'SkusController@collectionsDestroy')->name('admin.production.attr.collectionsDestroy');
    Route::delete('/products/all', 'ProductsController@collectionsDestroy')->name('admin.production.products.collectionsDestroy');
    Route::post('/products/all', 'ProductsController@collectionsRestore')->name('admin.production.products.collectionsRestore');

    Route::post('/products/{id}/destroy', 'ExpressZoneController@destroyCity')->name('admin.store.express-zone.destroyCity');
    Route::put('/express/enabled/{id}', 'ExpressController@enabled')->name('admin.store.express.enabled');
    Route::post('/express-zone/{id}/destroy', 'ExpressZoneController@destroyCity')->name('admin.store.express-zone.destroyCity');
    Route::post('/products/{id}/photo', 'ProductsController@photo')->name('admin.production.products.photo');
    Route::post('/products/photo-create', 'ProductsController@photoCreate')->name('admin.production.products.photoCreate');
    Route::post('/products/{id}/photo-delete', 'ProductsController@photoDelete')->name('admin.production.products.photoDelete');
    Route::post('/products/photo-delete-create', 'ProductsController@photoDeleteCreate')->name('admin.production.products.photoDeleteCreate');

    Route::post('/news/photo-create', 'NewsController@photoCreate')->name('admin.news.photoCreate');
    Route::post('/news/photo-delete', 'NewsController@photoDelete')->name('admin.news.photoDelete');
    Route::post('/news/restore/{id}', 'NewsController@restore')->name('admin.news.restore');

    Route::post('/header/photo-create', 'HeaderController@photoCreate')->name('admin.header.photoCreate');
    Route::post('/header/photo-delete', 'HeaderController@photoDelete')->name('admin.header.photoDelete');

    Route::post('/header-mobile/photo-create', 'HeaderMobileController@photoCreate')->name('admin.header-mobile.photoCreate');
    Route::post('/header-mobile/photo-delete', 'HeaderMobileController@photoDelete')->name('admin.header-mobile.photoDelete');

    Route::post('/stock/photo-create', 'StockController@photoCreate')->name('admin.store.stock.photoCreate');
    Route::post('/stock/photo-delete', 'StockController@photoDelete')->name('admin.store.stock.photoDelete');
    Route::post('/faqs/photo-create', 'FAQController@photoCreate')->name('admin.store.faqs.photoCreate');
    Route::post('/faqs/photo-delete', 'FAQController@photoDelete')->name('admin.store.faqs.photoDelete');

    Route::get('/reports', 'ReportsController@index')->name('admin.store.reports.index');
    Route::resource('/order', 'OrderController', ['as' => 'admin.store']);
    Route::resource('/express-zone', 'ExpressZoneController', ['as' => 'admin.store']);
    Route::resource('/express', 'ExpressController', ['as' => 'admin.store']);
    Route::resource('/coupon', 'CouponCodesController', ['as' => 'admin.store']);
    Route::get('/', 'DashboardController@index')->name('admin.root');
    Route::put('/status', 'DashboardController@status')->name('admin.root.status');

    Route::resource('/products', 'ProductsController', ['as' => 'admin.production']);
    Route::resource('/attr', 'SkusController', ['as' => 'admin.production']);
    Route::resource('/skus-category', 'SkusCategoriesController', ['as' => 'admin.production']);
    Route::resource('/category', 'CategoryController', ['as' => 'admin.production']);
    Route::resource('/brand', 'BrandController', ['as' => 'admin.production']);
    Route::resource('/currency', 'CurrencyController', ['as' => 'admin']);
    Route::resource('/news', 'NewsController', ['as' => 'admin']);
    Route::resource('/pay', 'PayController', ['as' => 'admin.store']);
    Route::resource('/header', 'HeaderController', ['as' => 'admin']);
    Route::resource('/header-mobile', 'HeaderMobileController', ['as' => 'admin']);
    Route::resource('/stock', 'StockController', ['as' => 'admin.store']);
    Route::resource('/faqs', 'FAQController', ['as' => 'admin.store']);
    Route::resource('/promotions', 'PromotionController', ['as' => 'admin.production']);
  });
}
