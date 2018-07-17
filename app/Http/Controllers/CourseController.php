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

        $courses = Course::where('teacher_id', Crypt::decrypt(urldecode($request->id)))->get();
        if($courses) {
            return self::setResponse($courses, 200, 0);
        } else {
            return self::setResponse(null, 500, -4005);
        }
    }
}
