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

//proxy
Route::get('/proxy/check-ip', ['as' => 'website.proxy.check-ip', 'uses' => 'ProxyController@checkIP']);
Route::get('/get-proxy', ['uses' => 'ProxyController@getProxy']);

Route::get('/transaction/approve', ['uses' => 'Api\TransactionController@apiApprove']);
Route::post('/service/receiveServiceInfo', ['uses' => 'Api\ServiceController@receiveServiceInfo']);

//service
Route::get('/service/serviceInQueue', ['uses' => 'Api\ServiceController@serviceInQueue']);
Route::post('/service/updateService', ['uses' => 'Api\ServiceController@updateService']);
Route::post('/service/scanPost', ['uses' => 'Api\ServiceController@scanPostService']);
Route::get('/service/logs', ['uses' => 'Api\ServiceController@logs']);
Route::get('/service/mobileGetService', ['uses' => 'Api\ServiceController@mobileGetService']);
Route::post('/service/mobileUpdateService', ['uses' => 'Api\ServiceController@mobileUpdateServiceV2']);
Route::get('/service/mobileUpdateServiceV2', ['uses' => 'Api\ServiceController@mobileUpdateServiceV2']);
Route::post('/service/mobileUpdateServiceV2', ['uses' => 'Api\ServiceController@mobileUpdateServiceV2']);

//Facebook token
Route::get('/facebookToken/getTokens', ['uses' => 'Api\FacebookTokenController@getTokens']);
Route::get('/facebookToken/updateTokens', ['uses' => 'Api\FacebookTokenController@updateTokens']);
Route::post('/facebookToken/updateTokens', ['uses' => 'Api\FacebookTokenController@updateTokens']);
Route::post('/facebookToken/createToken', ['uses' => 'Api\FacebookTokenController@createToken']);
Route::post('/facebookToken/logEvent', ['uses' => 'Api\FacebookTokenController@logEvent']);


