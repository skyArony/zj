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

Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});


$api = app('Dingo\Api\Routing\Router');
$api->version('v1', ['namespace' => 'App\Http\Controllers'], function ($api) {
    // 爬取课程信息
    $api->match(['get', 'post'] ,'/course', 'SpiderController@getCourseInfo');
    // 增加 tag
    $api->post('/tag', 'TagController@addTag');
    // 删除 tag
    $api->delete('/tag', 'TagController@removeTag');
    // 获取 tag
    $api->get('/tag', 'TagController@listTags');
    // 爬取课程树
    $api->post('/courseTree', 'SpiderController@getCourseTree');
    // 获取课程树
    $api->get('/courseTree', 'CourseTreeController@getCourseTree');
    // 更新课程树
    $api->put('/courseTree', 'CourseTreeController@setCourseTree');
    // 新建问卷
    $api->post('/survey', 'SurveyController@addSurvey');
    // 修改问卷
    $api->put('/survey', 'SurveyController@updateSurvey');
    // 查看一个问卷的数据
    $api->get('/survey', 'SurveyController@getSurvey');
    // 查看一个用户的所有课程
    $api->get('/course', 'CourseController@getAllCourse');
});


