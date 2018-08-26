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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    // 覆盖了原先的登录，添加了自定义的本身认证
    Route::post('login', 'LoginController@postLogin')->name('voyager.login');
    // 覆盖原先的注销
    Route::post('logout', 'LoginController@postLogout')->name('voyager.logout');
});


Route::group(['middleware' => 'admin.user'], function () {
    // 课程信息页
    Route::view('/admin/customCourse/{id}', 'customCourse');

});

// 课程视频播放页
Route::group(['prefix' => 'video'], function () {
    Route::get('course/{id}', function() {
        return view('video');
    });
    Route::get('customCourse/{id}', function() {
        return view('video');
    });
});

// 问卷预览和填写页
Route::view('/survey/{id}', 'survey');

// 获取生成的 PDF
Route::get('pdf/{id}', 'CustomCourseController@getPDF');

// 404
Route::view("404", "404");

// 首页
Route::view('index', 'index');