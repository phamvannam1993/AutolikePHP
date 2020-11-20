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

if ($_SERVER['SERVER_NAME'] !== 'localhost') {
    URL::forceScheme('https');
}

Route::get('/', ['as' => 'website.home.index', 'uses' => 'HomeController@index']);
Route::post('/group/form', ['as' => 'admin.group.save', 'uses' => 'Admin\GroupProfileController@form']);
Route::post('/page/form', ['as' => 'admin.page.save', 'uses' => 'Admin\PageController@form']);
Route::post('/login', ['as' => 'admin.login', 'uses' => 'Admin\AdminController@login']);
Route::get('/logout', ['as' => 'admin.logout', 'uses' => 'Admin\AdminController@logout']);

//user
Route::post('/user/form', ['as' => 'admin.user.form', 'uses' => 'Admin\UserController@form']);
Route::get('/user/list', ['as' => 'admin.user.list', 'uses' => 'Admin\UserController@index']);
Route::get('/login', ['as' => 'admin.login', 'uses' => 'Admin\AdminController@login']);
Route::post('/user/save', ['as' => 'admin.user.save', 'uses' => 'Admin\UserController@save']);
Route::get('/user/form/{userId}', ['as' => 'admin.user.update', 'uses' => 'Admin\UserController@form']);
Route::get('/register', ['as' => 'admin.user.register', 'uses' => 'Admin\UserController@form']);
Route::get('/user/form', ['as' => 'admin.user.add', 'uses' => 'Admin\UserController@form']);
Route::get('/user/delete/{userId}', ['as' => 'admin.user.delete', 'uses' => 'Admin\UserController@deleleUser']);
Route::get('/user/device', ['as' => 'admin.user.device', 'uses' => 'Admin\UserController@device']);
Route::get('/user/detail/{userId}', ['as' => 'admin.user.detail', 'uses' => 'Admin\UserController@detail']);


//fee
Route::get('/fee/form/{feeId}', ['as' => 'admin.fee.update', 'uses' => 'Admin\FeeController@form']);
Route::post('/fee/form', ['as' => 'admin.fee.update', 'uses' => 'Admin\FeeController@form']);
Route::get('/fee/form', ['as' => 'admin.fee.form', 'uses' => 'Admin\FeeController@form']);
Route::get('/fee/list', ['as' => 'admin.fee.list', 'uses' => 'Admin\FeeController@index']);
Route::get('/fee/delete/{userId}', ['as' => 'admin.fee.delete', 'uses' => 'Admin\FeeController@deleleFee']);
Route::post('/fee/update', ['as' => 'admin.fee.updateFee', 'uses' => 'Admin\FeeController@updateFee']);

//package
Route::post('/package/form', ['as' => 'admin.package.form', 'uses' => 'Admin\PackageController@form']);
Route::get('/package/list', ['as' => 'admin.package.list', 'uses' => 'Admin\PackageController@index']);
Route::post('/package/save', ['as' => 'admin.package.save', 'uses' => 'Admin\PackageController@save']);
Route::get('/package/form/{packageId}', ['as' => 'admin.package.update', 'uses' => 'Admin\PackageController@form']);
Route::get('/package/form', ['as' => 'admin.package.add', 'uses' => 'Admin\PackageController@form']);
Route::get('/package/delete/{packageId}', ['as' => 'admin.package.delete', 'uses' => 'Admin\PackageController@delete']);

//admin
Route::post('/admin/form', ['as' => 'admin.admin.form', 'uses' => 'Admin\AdminController@form']);
Route::get('/admin/form', ['as' => 'admin.admin.form', 'uses' => 'Admin\AdminController@form']);
Route::get('/admin/list', ['as' => 'admin.admin.list', 'uses' => 'Admin\AdminController@list']);
Route::get('/admin/delete/{userId}', ['as' => 'admin.admin.delete', 'uses' => 'Admin\AdminController@deleleUser']);
Route::get('/admin/detail/{userId}', ['as' => 'admin.admin.detail', 'uses' => 'Admin\AdminController@detail']);
Route::get('/admin/form/{userId}', ['as' => 'admin.admin.update', 'uses' => 'Admin\AdminController@form']);

Route::get('/page/list', ['as' => 'admin.page.list', 'uses' => 'Admin\PageController@index']);
Route::get('/page/detail/{pageId}', ['as' => 'admin.page.detail', 'uses' => 'Admin\PageController@detail']);

Route::get('/', ['as' => 'website.home.index', 'uses' => 'Website\HomeController@index']);

//User manager
Route::get('/thanh-vien', ['as' => 'website.user.index', 'uses' => 'Website\UserController@index']);
Route::get('/cong-tac-vien', ['as' => 'website.agency.index', 'uses' => 'Website\UserController@agency']);
Route::post('/user/update-status', ['as' => 'website.user.apiUpdateStatus', 'uses' => 'Website\UserController@apiUpdateStatus']);
Route::post('/user/updateRole', ['as' => 'website.user.updateRole', 'uses' => 'Website\UserController@updateRole']);
Route::get('/chi-tiet-thanh-vien/{userId}', ['as' => 'website.user.history', 'uses' => 'Website\UserController@history']);

//transaction manager

Route::get('/lich-su-giao-dich/{userId}', ['as' => 'website.transaction.history', 'uses' => 'Admin\TransactionController@history']);
Route::get('/giao-dich', ['as' => 'website.transaction.index', 'uses' => 'Admin\TransactionController@index']);
Route::get('/giao-dich/{code}', ['as' => 'website.transaction.show', 'uses' => 'Admin\TransactionController@show']);
Route::post('/transaction/create', ['as' => 'website.transaction.apiCreate', 'uses' => 'Admin\TransactionController@apiCreate']);
Route::post('/transaction/apiUpdateStatus', ['as' => 'website.transaction.apiUpdateStatus', 'uses' => 'Admin\TransactionController@apiUpdateStatus']);

//service manager
Route::get('/dich-vu', ['as' => 'website.service.index', 'uses' => 'Website\ServiceController@index']);
Route::get('/dich-vu/mua-goi', ['as' => 'website.service.create', 'uses' => 'Website\ServiceController@create']);
Route::get('/dich-vu/chi-tiet/{code}', ['as' => 'website.service.show', 'uses' => 'Website\ServiceController@show']);
Route::post('/service/update-status', ['as' => 'website.service.apiUpdateStatus', 'uses' => 'Website\ServiceController@apiUpdateStatus']);
Route::post('/service/create', ['as' => 'website.transaction.apiCreate', 'uses' => 'Website\ServiceController@apiCreate']);
Route::get('/dich-vu/type/{type}', ['as' => 'website.service.indexType', 'uses' => 'Website\ServiceController@indexType']);

//facebook bot manager
Route::get('/fb-bot', ['as' => 'website.fb-bot.index', 'uses' => 'Website\FacebookBotController@index']);
Route::get('/fb-bot/log/{uid}', ['as' => 'website.fb-bot.show', 'uses' => 'Website\FacebookBotController@show']);
Route::get('/fb-bot/show/redirect', ['as' => 'website.fb-bot.showRedirect', 'uses' => 'Website\FacebookBotController@showRedirect']);

//setting manager
Route::get('/setting', ['as' => 'website.setting.edit', 'uses' => 'Website\SettingController@edit']);
Route::post('/setting/update', ['as' => 'website.setting.update', 'uses' => 'Website\SettingController@update']);

//import data
Route::get('/import/form-import', ['as' => 'website.import.formImport', 'uses' => 'Website\ImportController@formImport']);
Route::post('/import/import-data', ['as' => 'website.import.apiImportData', 'uses' => 'Website\ImportController@apiImportData']);

//gift code
Route::get('/gift-code', ['as' => 'website.gift-code.index', 'uses' => 'Website\GiftCodeController@index']);
Route::get('/gift-code/create', ['as' => 'website.gift-code.create', 'uses' => 'Website\GiftCodeController@create']);
Route::get('/gift-code/history', ['as' => 'website.gift-code.history', 'uses' => 'Website\GiftCodeController@history']);
Route::post('/gift-code/update-status', ['as' => 'website.gift-code.apiUpdateStatus', 'uses' => 'Website\GiftCodeController@apiUpdateStatus']);
Route::post('/gift-code/apiCreate', ['as' => 'website.gift-code.apiCreate', 'uses' => 'Website\GiftCodeController@apiCreate']);

Route::get('/log', ['as' => 'admin.log', 'uses' => 'Admin\LogController@listLog']);
