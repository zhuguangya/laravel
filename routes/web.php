<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/aa', function () {
     return $hashed = Hash::make('bb');
});
Route::get('login','LoginController@login');
Route::get('loginaction','LoginController@loginaction');
Route::group(['middleware' => App\Http\Middleware\CheckToken::class,],function(){
Route::get('login/loginout','LoginController@loginout');
	
});
Route::any('show/show','ShowController@show');
Route::get('show/show1','ShowController@show1');
Route::get('show/show3','ShowController@show3');
Route::get('show/tree','ShowController@tree');
Route::get('show/denglu','ShowController@denglu');
// Route::get('show/shop','ShowController@shop');
// Route::get('show/zhu','ShowController@zhu');
Route::get('show/addaction','ShowController@addaction');
Route::match(['get', 'post'], 'foo', function () {
    return 'This is a request from get or post';
});
