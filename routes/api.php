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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');



// 公用api请求
Route::group([
    'prefix'    => 'wechat',
    'namespace' => 'Wechat',
    'middleware'=> ['lang']
], function() {

    // 微信公众号JS-SDK配置请求,注意,这里必须是any请求,不然jsonp会报错
    Route::any('get-wechat-jssdk', 'WechatController@getWechatJssdk');

    // 通用获取微信公众号token接口
    Route::post('get-wechat-token', 'WechatController@getWechatToken');
});
