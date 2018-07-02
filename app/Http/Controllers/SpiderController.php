<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use GuzzleHttp\Cookie\CookieJar;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Crypt;
use App\Models\DB\Course;
use App\User;
use App\Models\DB\CourseTree;

class SpiderController extends ApiController
{
    // api：爬取课程信息
    // 这个必须数据库存在有效的 cookies 才能正常使用
    // 这个接口会获取当前大学城上的课程数据并覆盖现有的
    // 这个不仅作为接口（POST 方式）还作为一个可以带 cookie 访问的页面（GET 方式），只是不会展示内容，直接重定向
    public function getCourseInfo(Request $request){
        // TODO validate

        $mooc_course = 'http://worlduc.com/APP/OnlineCourse/teaching/pubcourse.aspx';
        $mooc_course_detail = "http://worlduc.com/APP/OnlineCourse/teaching/base.aspx?op=getmodel&courseID=";

        $cookieJar = new CookieJar;
        if($request->has('email')) $email = $request->email;
        elseif(Cookie::get('email')) $email = Crypt::decrypt(Cookie::get('email'));
        else return self::setResponse(null, 400, -4004);
        $cookieJar = unserialize(User::where('email', $email)->first()->cookies);
        
        $guzzleClient = new GuzzleClient(['cookies' => true]);
        $response = $guzzleClient->request('GET', $mooc_course, ['cookies' => $cookieJar]);
        preg_match_all('/\/APP\/OnlineCourse\/course\/course.aspx\?courseID=(\d+)/', $response->getBody()->getContents(), $matches);
        $matches = array_unique($matches[1]);

        $courseInfo = array();

        foreach ($matches as $value) {
            $course = array();
            $response = $guzzleClient->request('POST', $mooc_course_detail.$value, ['cookies' => $cookieJar]);
            $response_arr = json_decode($response->getBody()->getContents(), 1);

            $course['course_id'] = $value;
            $course['name'] = $response_arr['CourseName'];
            $course['pic'] = 'http://worlduc.com'.$response_arr['CoursePic'];
            $course['teacher'] = $response_arr['Publisher'];
            $course['teacher_id'] = $response_arr['PublishID'];
            $course['intro'] = $response_arr['Description'];

            $course = Course::updateOrCreate(['course_id' => $value], $course);
            $courseInfo[] = $course;
        }
        if(Cookie::get('email')) {
            return redirect('admin/courses');
        } elseif($request->has('email')) {
            return self::setResponse($courseInfo, 200, 0);
        }
    }
    
    // api：爬取课程树信息-无需登录
    // 这个接口会获取当前大学城上的课程树数据并覆盖现有的
    public function getCourseTree(Request $request) {
        // TODO validate 有 has 是否还有必要

        $mooc_course_tree = "http://worlduc.com/APP/OnlineCourse/course/course.aspx?courseID=";
        $mooc_course_tree_detail = 'http://worlduc.com/APP/OnlineCourse/course/Ajax_CourseHour.ashx?op=GetCourseHour&courseHourID=';
        if($request->has('courseId')) $courseId = $request->courseId;
        else return self::setResponse(null, 400, -4004);

        $guzzleClient = new GuzzleClient(['cookies' => true]);
        $response = $guzzleClient->request('GET', $mooc_course_tree.$courseId);
        preg_match('/courselearn.aspx\?courseHourID=(\d+)/', $response->getBody()->getContents(), $matches);
        $periodId = $matches[1];
        
        $response = $guzzleClient->request('GET', $mooc_course_tree_detail.$periodId);
        $courseTreeData = json_decode($response->getBody()->getContents(), 1)['DirList'];

        $courseTreeInfo = array();

        foreach ($courseTreeData as $chapterItem) {
            $courseTreeChapter = [];
            foreach ($chapterItem['Hours'] as $periodItem) {
                $courseTreeChapter[$periodItem['HourID']] = array(
                    'period_title' => $periodItem['HourName'],
                    'period_summary' => $periodItem['HourAbstract'],
                );
            }
            $courseTreeInfo[$chapterItem['SectionId']] = $courseTreeChapter;
            $courseTreeInfo[$chapterItem['SectionId']]['chapter_name'] = $chapterItem['SectionName'];
        }

        // 是否是增量更新
        if($request->has('isAdd'))
            if($request->isAdd == 'true') {
                $courseTreeOldJson = CourseTree::where('course_id', $courseId)->first();
                $courseTreeOldArray = json_decode($courseTreeOldJson->data, 1);
                foreach ($courseTreeOldArray as $chapter_id => $chapter) {
                    foreach ($chapter as $section_id => $section) {
                        if(isset($section['tags']))
                            $courseTreeInfo[$chapter_id][$section_id]['tags'] = $section['tags'];
                        if(isset($section['claims']))    
                            $courseTreeInfo[$chapter_id][$section_id]['claims'] = $section['claims'];
                    }
                }
            }

        $courseTree = CourseTree::updateOrCreate(
            ['course_id' => $courseId], ['data' => json_encode($courseTreeInfo)]
        );
        return self::setResponse($courseTreeInfo, 200, 0);
    }
}
