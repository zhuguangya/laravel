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
// Route::middleware('v1.0')->get(function(){
// 	 Route::get('show/show2','')
// });
Route::get('users/{user}', function (App\User $user) {
    dd($user);
});
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('insert', 'CartController@insert');
    Route::post('buycar','CartController@buycar');
    Route::post('greed','CartController@greed');
    Route::post('memberaddress','MemberaddressController@memberaddress');
    Route::post('address','MemberaddressController@address');
    Route::post('cartshow','MemberaddressController@cartshow');
    Route::post('cartwo','CartwoController@cartwo');
    Route::post('cartwo1','CartwoController@cartwo1');
    Route::post('addaction','CartwoController@addaction');
});
Route::group([

    'middleware' => 'api',
    'prefix' => 'pay'

], function ($router) {

    Route::get('return','PayController@return');
    Route::any('notify','PayController@notify');
    Route::get('index','PayController@index');

});
Route::get('show/denglu','ShowController@denglu');
Route::post('show/shop','ShowController@shop');
Route::post('show/product','ShowController@product');