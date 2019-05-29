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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});


$api = app('Dingo\Api\Routing\Router');
$api->version('v1', ['namespace' => 'App\Http\Controllers', 'middleware' => ['jwt.auth']], function ($api) {
    /* ********************** 其他 ********************** */
    // 爬取课程信息
    $api->post('/course', 'SpiderController@getCourseInfo');
    // 查看一个用户的所有课程
    $api->get('/user/course', 'CourseController@getAllCourseByUserId');
    // 获取一个定制化课程的数据
    $api->get('/customCourse/{courseId}', 'CustomCourseController@getCustomCourse');
    // 获取已经登录的用户信息
    $api->get('/me', 'LoginController@me');

    
    /* ********************** 知识点-tag ********************** */
    // 获取 tag
    $api->get('/tag/{courseId}', 'TagController@listTags');
    // 增加 tag 
    $api->post('/tag/{courseId}', 'TagController@addTag');
    // 删除 tag 
    $api->delete('/tag/{courseId}', 'TagController@removeTag');


    /* ********************** 课程树-courseTree ********************** */
    // 爬取课程树 
    $api->post('/courseTree/{courseId}', 'SpiderController@getCourseTree');
    // 更新课程树 
    $api->put('/courseTree/{courseId}', 'CourseTreeController@setCourseTree');


    /* ********************** 问卷记录-surveyRecord ********************** */
    // 获取一个用户的所有填写记录
    $api->get('/surveyRecord', 'SurveyRecordController@getRecord');
    // 删除一条问卷填写记录
    $api->delete('/surveyRecord/{surveyId}', 'SurveyRecordController@deleteRecord');


    /* ********************** 研究成果-ResearchResults ********************** */
    // 根据用户 ID 返回其创建的所有队伍
    $api->get('/user/team', 'ResearchResultsController@getTeamsByUserId');
    // 根据队伍 ID 返回其所参加的所有(未过期)课题
    // $api->get('/team/task', 'ResearchResultsController@getTasksByTeamId');
    // 获取一个用户参加的所有组的所有研究成果
    $api->get('/user/results', 'ResearchResultsController@getResults');
    // 根据 id 获取一个科研成果的详细信息
    $api->get('/result/{resultId}', 'ResearchResultsController@getResultDetail');


    /* ********************** 课题-task ********************** */
    // 根据队伍 ID 返回所有未过提交期的课题
    $api->get('/task/submit', 'TaskController@getSubmitingTaskByTeamId');
    // 根据队伍 ID 返回所有未过申请期的课题
    $api->get('/task/request', 'TaskController@getRequestingTaskByTeamId');
    // 获取一个用户参与的所有 task
    $api->get('/user/tasks', 'TaskController@getTasksByUserId');


    /* ********************** 团队-team ********************** */
    // 获取某一个团队的信息
    $api->get('/team/{teamId}', 'TeamController@getTeam');
    // 删除队伍的一个成员
    $api->delete('/team/member', 'TeamController@deleteMember');
    // 解散一个团队
    $api->delete('/team/{teamId}', 'TeamController@deleteTeam');
    // 添加一个成员到一个队伍
    $api->post('/team/member', 'TeamController@addMember');
    // 一支队伍报名一个课题
    $api->post('/task/sign', 'TeamController@signTask');
    // 一支队伍退出一个课题
    $api->post('/task/leave', 'TeamController@leaveTask');
    // 退出团队
    $api->delete('/user/team/{teamId}', 'TeamController@leaveTeam');


    /* ********************** 用户-user ********************** */
    // 搜索用户
    $api->get('/search/user', 'UserController@search');
    // 绑定用户联系信息
    $api->post('/user/bind/{type}', 'UserController@bindContact');
    // 获取一个用户所有的团队
    $api->get('/user/teams', 'UserController@getMyTeams');
    // 绑定一个用户的学号
    $api->patch('/bindSid', "UserController@bindSid");
    
    
    /* ********************** 申请书-request ********************** */
    // 根据 id 获取一个 申请书 的详细内容
    $api->get('/request/{id}', "RequestController@getRequest");
    // 审查申请书
    $api->patch('/request/{id}', "RequestController@reviewRequest");

    /* ********************** 题库-question ********************** */
    // 题库-加题
    $api->post('/question', "QuestionController@addQuestion");
    // 题库-删题
    $api->delete('/question/{questionId}', "QuestionController@deleteQuestionById");
    // 题库-改题
    $api->put('/question/{questionId}', "QuestionController@updateQuestion");


    /* ********************** 班级-class ********************** */
    // 班级-创建
    $api->post('/class', "ClassGroupController@create");
    // 班级-修改
    $api->patch('/class/{classId}', "ClassGroupController@update");
    // 班级-获取
    $api->get('/class/{classId}', "ClassGroupController@show");
    // 班级-列举一个用户创建的所有班级
    $api->get('/classList', "ClassGroupController@browse");
    // 班级-添加成员 [sid: 用户 ID, classId: 课程 ID]
    $api->post('/class/member', "ClassGroupController@addStudent");
    // 班级-删除成员 [sid: 用户 ID, classId: 课程 ID]
    $api->delete('/class/member', "ClassGroupController@removeStudent");
    // 班级-获取一个班级的所有成员
    $api->get('/class/member/{classId}', "ClassGroupController@getMemberList");

    /* ********************** 表格-chart ********************** */
    $api->get('/chart/surveyRecord', "ChartController@getSurveyRecord");
});

$api->version('v1', ['namespace' => 'App\Http\Controllers'], function ($api) {
    // 题库-获取一门课程下的所有题
    $api->get('/question/{courseId}', "QuestionController@getQuestionsByCourseId");
    // 根据课程 ID 查看课程信息
    $api->get('/course/{courseId}', 'CourseController@getCourse');
    // 获取一门课程的所有 tag (详细)
    $api->get('/tag/detail/{courseId}', 'TagController@getTagsDetail');
    // 填写问卷[入学, 期中, 期末]
    $api->post('/surveyRecord/{courseId}', 'SurveyRecordController@addRecord');
    // 检查一个用户是否填写过某个问卷
    $api->get('/surveyRecord/check/{courseId}', 'SurveyRecordController@checkRecord');
    // 加入班级
    $api->post('/joinClass/{classId}', "ClassGroupController@joinClass");

    /* ********************** 首页-课题 ********************** */
    // 获取系统中所有的研究课题
    $api->get('/task', 'TaskController@getAllTask');
    // 根据 id 获取一个科研课题的详细信息
    $api->get('/task/{taskId}', 'TaskController@getTaskDetail');
    // 获取一个用户的其他课题信息
    $api->get('/task/more/{userId}', 'TaskController@getMoreTasks');

    /* ********************** 首页-团队 ********************** */
    // 获取系统中所有的团队
    $api->get('/team', 'TeamController@getAllTeam');
    // 获取一只队伍所有的成员信息
    $api->get('/team/member/{teamId}', 'TeamController@getAllMember');

    /* ********************** 首页-课程 ********************** */
    // 获取系统中所有的课程
    $api->get('/course', 'CourseController@getAllCourse');

    /* ********************** 课程树-courseTree ********************** */
    // 获取课程树
    $api->get('/courseTree/{courseId}', 'CourseTreeController@getCourseTree');

    /* ********************** 登录 - login ********************** */
    // 获取大学城登陆校验的随机 key
    $api->get('/loginKey', "LoginController@loginKey");
});

