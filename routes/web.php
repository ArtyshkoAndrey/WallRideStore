<?php
// Для всех
// Продукты переписать под ресурс
Route::redirect('/', '/products')->name('root'); // Главаня
Route::get('/about', 'PagesController@about')->name('about'); // Главаня
Route::get('/contact', 'PagesController@contact')->name('contact'); // Главаня
Route::get('products', 'ProductsController@index')->name('products.index'); // Главная с товарами
Route::get('products/all', 'ProductsController@all')->name('products.all');
Route::get('products/search', 'ProductsController@search')->name('products.search'); // Главная с товарами
Route::get('product/{product}', 'ProductsController@show')->name('products.show');
Route::resource('news', 'NewsController')->except([
  'edit', 'create', 'destroy', 'create'
]);


Auth::routes(['verify' => true]);

// Только для авторизированных и подтверждённых почту
Route::group(['middleware' => ['auth', 'verified']], function() {
//  TODO Добавить доступ заказа и тп не auth пользователей

    Route::post('products/{product}/favorite', 'ProductsController@favor')->name('products.favor');
    Route::delete('products/{product}/favorite', 'ProductsController@disfavor')->name('products.disfavor');
    Route::get('products/favorites', 'ProductsController@favorites')->name('products.favorites');

    Route::post('cart', 'CartController@add')->name('cart.add');
    Route::post('cart/minus', 'CartController@minus')->name('cart.minus');
    Route::get('cart', 'CartController@index')->name('cart.index');
    Route::delete('cart/{sku}', 'CartController@remove')->name('cart.remove');

    Route::post('orders', 'OrdersController@store')->name('orders.store');
    Route::post('orders/success/{no}', 'OrdersController@success')->name('orders.success');
    Route::get('orders', 'OrdersController@index')->name('orders.index');
    Route::get('orders/create', 'OrdersController@create')->name('orders.create');
    Route::get('coupon_codes/{code}', 'CouponCodesController@show')->name('coupon_codes.show');
});

// Только для авторизированный пользователей
Route::group(['middleware' => ['auth']], function() {
  Route::resource('profile', 'ProfileController')->except([
    'edit', 'create', 'destroy', 'show', 'create'
  ]);
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
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
  Route::resource('/order', 'OrderController', ['as' => 'admin.store']);
  Route::redirect('/', route('admin.store.order.index'))->name('admin.root');
});
