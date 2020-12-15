<?php

use Illuminate\Http\Request;

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


Route::post('city/{city}/{country?}', ['as' => 'api.city', 'uses' => 'ApiController@city']);
Route::post('country/{country}', ['as' => 'api.country', 'uses' => 'ApiController@country']);
Route::post('category/{category}', ['as' => 'api.category', 'uses' => 'ApiController@category']);
Route::post('brand/{brand}', ['as' => 'api.brand', 'uses' => 'ApiController@brand']);
Route::post('companies', ['as' => 'api.companies', 'uses' => 'ApiController@companies']);

Route::post('check/email', 'ApiController@checkEmail')->name('api.check.email');
