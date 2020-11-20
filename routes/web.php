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
Route::group(['middleware' => 'locale'], function() {
    Route::get('change-language/{language}', 'HomeController@changeLanguage')
        ->name('user.change-language');
});
Route::get('/viewClone', ['as' => 'admin.clone-facebook.cloneFacebook', 'uses' => 'Admin\CloneFacebookController@index']);
Route::get('/viewAction/{uid}', ['as' => 'admin.action-facebook.ActionFacebook', 'uses' => 'Admin\ActionFacebookController@viewAction']);

Route::get('/login', ['as' => 'admin.login', 'uses' => 'Admin\AdminController@login']);
Route::post('/login', ['as' => 'admin.login', 'uses' => 'Admin\AdminController@login']);
Route::get('/logout', ['as' => 'admin.logout', 'uses' => 'Admin\AdminController@logout']);

Route::get('/user/form/{userId}', ['as' => 'admin.user.update', 'uses' => 'Admin\UserController@form']);
Route::get('/register', ['as' => 'admin.user.register', 'uses' => 'Admin\UserController@form']);
Route::get('/user/form', ['as' => 'admin.user.add', 'uses' => 'Admin\UserController@form']);
Route::post('/register', ['as' => 'admin.user.save', 'uses' => 'Admin\UserController@form']);
Route::get('/user/change-pass', ['as' => 'user.changePassword', 'uses' => 'Admin\UserController@changPassword']);
Route::post('/user/change-pass', ['as' => 'user.changePassword', 'uses' => 'Admin\UserController@changPassword']);

//send SMS
Route::post('/check-number', ['as' => 'login.checkNumer', 'uses' => 'Admin\AdminController@checkNumber']);

Route::get('/', ['as' => 'website.home.index', 'uses' => 'Website\HomeController@index']);
Route::get('/nap-tien', ['as' => 'website.service.money', 'uses' => 'Website\HomeController@money']);
Route::get('/mua-dich-vu', ['as' => 'website.service.buyService', 'uses' => 'Website\HomeController@buyService']);



//transaction manager
Route::get('/giao-dich', ['as' => 'website.transaction.index', 'uses' => 'Website\TransactionController@index']);
Route::get('/giao-dich/{code}', ['as' => 'website.transaction.show', 'uses' => 'Website\TransactionController@show']);
Route::post('/transaction/create', ['as' => 'website.transaction.apiCreate', 'uses' => 'Website\TransactionController@apiCreate']);

//service manager
Route::get('/dich-vu', ['as' => 'website.service.index', 'uses' => 'Website\ServiceController@index']);
Route::get('/dich-vu/mua-goi', ['as' => 'website.service.create', 'uses' => 'Website\ServiceController@create']);
Route::post('/service/update-status', ['as' => 'website.service.apiUpdateStatus', 'uses' => 'Website\ServiceController@apiUpdateStatus']);
Route::post('/service/create', ['as' => 'website.service.apiCreate', 'uses' => 'Website\ServiceController@apiCreate']);
Route::post('/service/cancel', ['as' => 'website.service.apiCancel', 'uses' => 'Website\ServiceController@apiCancel']);
Route::get('/service/history', ['as' => 'website.service.history', 'uses' => 'Website\ServiceController@history']);
Route::get('/service/report', ['as' => 'website.service.report', 'uses' => 'Website\ServiceController@report']);
Route::get('/danh-sach-viplike', ['as' => 'website.service.Viplikelist', 'uses' => 'Website\ServiceController@viplikeList']);

Route::get('/dich-vu/type/{type}', ['as' => 'website.service.indexType', 'uses' => 'Website\ServiceController@indexType']);
Route::get('/lich-su-giao-dich/{userId}', ['as' => 'website.transaction.history', 'uses' => 'Website\TransactionController@history']);

Route::get('/user/list', ['as' => 'website.user.index', 'uses' => 'Website\UserController@index']);
Route::post('/user/update-status', ['as' => 'website.user.apiUpdateStatus', 'uses' => 'Website\UserController@apiUpdateStatus']);

//gift code
Route::get('/gift-code-use', ['as' => 'website.gift-code.using', 'uses' => 'Website\GiftCodeController@using']);
Route::get('/gift-code', ['as' => 'website.gift-code.index', 'uses' => 'Website\GiftCodeController@index']);
Route::get('/gift-code/create', ['as' => 'website.gift-code.create', 'uses' => 'Website\GiftCodeController@create']);
Route::get('/gift-code/history', ['as' => 'website.gift-code.history', 'uses' => 'Website\GiftCodeController@history']);
Route::post('/gift-code/update-status', ['as' => 'website.gift-code.apiUpdateStatus', 'uses' => 'Website\GiftCodeController@apiUpdateStatus']);
Route::post('/gift-code/apiCreate', ['as' => 'website.gift-code.apiCreate', 'uses' => 'Website\GiftCodeController@apiCreate']);
Route::post('/gift-code', ['as' => 'website.gift-code.apply', 'uses' => 'Website\GiftCodeController@applyGiftCode']);

//user profile
Route::get('/profile', ['as' => 'website.user.profile', 'uses' => 'Website\UserController@profile']);
Route::post('/user/updateProfile', ['as' => 'website.user.updateProfile', 'uses' => 'Website\UserController@updateProfile']);

Route::any('{all}', function(){
    return [];
})->where('all', '.*');

if ($_SERVER['SERVER_NAME'] !== 'localhost') {
    URL::forceScheme('https');
}