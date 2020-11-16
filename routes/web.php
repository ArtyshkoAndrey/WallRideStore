<?php
// Для всех
use App\Models\Product;
use App\Models\User;
use App\Notifications\RegisterPassword;
use Laravel\Socialite\Facades\Socialite;

//

if ((new App\Models\Settings)->statusSite()) {

  /* Sitemap */
  Route::get('/sitemap', 'SitemapController@index')->name('sitemap');

  Route::get('/auth/vk/redirect', function () {
    return Socialite::driver('vkontakte')->redirect();
  })->name('vk.redirect');
  Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
  })->name('google.redirect');

  Route::get('/facebook/items', function () {
    $products = Product::all();

    return response()->view('sitemap.items', compact('products'))->header('Content-Type', 'text/xml');
  });

  Route::get('/auth/vk', function () {
    Auth::logout();
    try {
      $user = Socialite::driver('vkontakte')->user();
      if ($user->email) {
        $userM = User::where('email', $user->email)->first();
        if ($userM) {
          Auth::login($userM, true);
        } else {
          $userM = new User();
          $userM->email = $user->email;
          $userM->name = $user->name;

          $url = $user->avatar;
          $imageName = $userM->name . '-' . $user->id . '.jpg';
          $destinationPath = public_path('storage/avatar/thumbnail') . '/' . $imageName;
          file_put_contents($destinationPath, file_get_contents($url));

          $userM->avatar = $imageName;
          $pass = str_random(10);
          $userM->password = bcrypt($pass);
          $userM->save();
          $userM->notify(new RegisterPassword($userM->email, $pass));
          Auth::login($userM, true);
        }
      } else {
        return redirect()->route('register')->with(['name' => $user->name, 'status' => 'Error', 'message' => 'В дальнейшем необходимо привязать свою почту в профиле Вконтакте']);
      }
    } catch (GuzzleHttp\Exception\ClientException $e) {
      return redirect()->route('vk.redirect');
    }
    return redirect()->route('profile.index');
  })->name('vk.auth');

  Route::get('/auth/google', function () {
    Auth::logout();
    try {
      $user = Socialite::driver('google')->user();
      if ($user->email) {
        $userM = User::where('email', $user->email)->first();
        if ($userM) {
          Auth::login($userM, true);
        } else {
          $userM = new User();
          $userM->email = $user->email;
          $userM->name = $user->name;

          $url = $user->avatar;
          $imageName = $userM->name . '-' . $user->id . '.jpg';
          $destinationPath = public_path('storage/avatar/thumbnail') . '/' . $imageName;
          file_put_contents($destinationPath, file_get_contents($url));

          $userM->avatar = $imageName;
          $pass = str_random(10);
          $userM->password = bcrypt($pass);
          $userM->save();
          $userM->notify(new RegisterPassword($userM->email, $pass));
          Auth::login($userM, true);
        }
      } else {
        return redirect()->route('register')->with(['name' => $user->name, 'status' => 'Error', 'message' => 'В дальнейшем необходимо привязать свою почту в профиле Google']);
      }
    } catch (GuzzleHttp\Exception\ClientException $e) {
      return redirect()->route('login');
    }
    return redirect()->route('profile.index');
  })->name('google.auth');

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
  Route::get('currency/change/{currency}', ['as' => 'currency-change', 'uses' => 'PagesController@currency']);
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

  Route::get('orders/create', 'OrdersController_2@create')->name('orders.create');
  Route::get('orders/cloudpayment', 'OrdersController@cloudpayment')->name('orders.cloudpayment');
  Route::post('orders', 'OrdersController@store')->name('orders.store');
  Route::get('orders/success/{id}', 'OrdersController@success')->name('orders.success');
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

    Route::put('/express/enabled/{id}', 'ExpressController@enabled')->name('admin.store.express.enabled');
    Route::post('/express-zone/{id}/destroy', 'ExpressZoneController@destroyCity')->name('admin.store.express-zone.destroyCity');

    Route::post('/products/{id}/photo', 'ProductsController@photo')->name('admin.production.products.photo');
    Route::post('/products/photo-create', 'ProductsController@photoCreate')->name('admin.production.products.photoCreate');
    Route::post('/products/photo-delete', 'ProductsController@photoDelete')->name('admin.production.products.photoDelete');

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
    Route::post('/faqs/upload/tiny/image', 'FAQController@tinyUploadImage')->name('admin.store.faqs.upload.tiny.image');
    Route::resource('/promotions', 'PromotionController', ['as' => 'admin.production']);
  });
}
