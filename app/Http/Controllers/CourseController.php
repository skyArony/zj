<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\Course;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;

class CourseController extends ApiController
{
    //获取所有的课程
    public function getAllCourse(Request $request) {
        // TODO validate

        if (Cookie::get('id')) $userId = Crypt::decrypt(Cookie::get('id'));
        else return self::setResponse(null, 400, -4007);    // 未登录

        $courses = Course::where('teacher_id', $userId)->get();
        if($courses) {
            return self::setResponse($courses, 200, 0);
        } else {
            return self::setResponse(null, 500, -4005);
        }
    }

    // 根据课程 ID 获取课程信息
    public function getCourse(Request $request) {
        // TODO validate

        $courses = Course::where('id', $request->courseId)->first();
        if($courses) {
            return self::setResponse($courses, 200, 0);
        } else {
            return self::setResponse(null, 500, -4005);
        }
    }
}
