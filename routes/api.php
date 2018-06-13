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


$api = app('Dingo\Api\Routing\Router');
$api->version('v1', ['namespace' => 'App\Http\Controllers'], function ($api) {
    // token 相关
    $api->get('/login', 'LoginController@loginCheck');

    // test
    $api->post('/test', 'CourseTreeController@setTag');
    
    
    // 获取课程信息
    $api->get('/course', 'SpiderController@getCourseInfo');

    // 获取课程树
    $api->get('/courseTree', 'SpiderController@getCourseTree');



});

