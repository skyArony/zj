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
    // api：爬取课程信息-这个必须登录才能获取到
    public function getCourseInfo(Request $request){
        $mooc_course = 'http://worlduc.com/APP/OnlineCourse/teaching/pubcourse.aspx';
        $mooc_course_detail = "http://worlduc.com/APP/OnlineCourse/teaching/base.aspx?op=getmodel&courseID=";

        $cookieJar = new CookieJar;
        if($request->has('email')) $email = $request->email;
        elseif(Cookie::get('email')) $email = Crypt::decrypt(Cookie::get('email'));
        else return self::setResponse(null, 400, -4004);
        $cookieJar = unserialize(User::where('email', $email)->first()->cookies);

        // $goutteClient = new Client();
        // $goutteClient->setClient($guzzleClient);
        // $response = $goutteClient->request('GET', $mooc_course, ['cookies' => $cookieJar]);
        
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

            $course = Course::firstOrCreate($course);
            $courseInfo[] = $course;
        }
        return self::setResponse($courseInfo, 200, 0);
    }
    
    // api：爬取课程树信息-无需登录
    public function getCourseTree(Request $request) {
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

        $courseTree = CourseTree::firstOrCreate(
            ['course_id' => $courseId], ['data' => json_encode($courseTreeInfo)]
        );
        return self::setResponse($courseTreeInfo, 200, 0);
    }
}
