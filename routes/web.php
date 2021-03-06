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

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    // 覆盖了原先的登录，添加了自定义的本身认证
    Route::post('login', 'LoginController@postLogin')->name('voyager.login');
    // 覆盖原先的注销
    Route::post('logout', 'LoginController@postLogout')->name('voyager.logout');
});

// 自定义的页要加到认证后的,就加到这个里面
Route::group(['middleware' => 'admin.user'], function () {
    // 团队添加成员
    Route::view('/admin/teams/member/{teamId}', 'addTeamMember');
    // 班级添加成员
    Route::view('/admin/class/member/{classId}', 'addClassMember');
    // 导出 PDF
    Route::view('/pdfpage/{courseId}', 'pdf');
    // 教师查看学生计划
    Route::view('/showCustomCourse/{courseId}/{recordId}', 'showCustomCourse');
    // 导出简化版 PDF
    Route::view('/pdfeasypage/{courseId}', 'pdfEasy');
    // 图表数据显示
    Route::view('/admin/chart', 'chart');
});


// 首页
Route::view('/', 'index');

// 404
Route::view("404", "404");

// 课堂问卷,选择课程
Route::view('/classsurvey/{classId}', 'survey');
// 自动问卷
Route::view('/autosurvey/{courseId}', 'autoSurvey');

// QQ 登陆
Route::get('/socialite/callback', 'SocialiteController@callback');
Route::get('/socialite/bind/qq', 'SocialiteController@bindQQ');
Route::get('/socialite/login/qq', 'SocialiteController@loginQQ');

// 大学城直接登陆
Route::view('/worlduc/login', 'worlducLogin');
Route::get('/loginKeyCheck', "LoginController@loginKeyCheck");

// 绑定学号
Route::view('/bindsid', 'bindSid');

// 加入班级
Route::view('/joinclass/{classId}', 'joinClass');