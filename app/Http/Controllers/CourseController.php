<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\Course;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;

class CourseController extends ApiController
{
    // 通过 cookie 中的 userid 获取用户所有的课程
    public function getAllCourseByUserId(Request $request) {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $courses = Course::where('teacher_id', $uid)->get();
        if($courses) {
            return self::setResponse($courses, 200, 0);
        } else {
            return self::setResponse(null, 404, -4005);
        }
    }

    // 根据课程 ID 获取课程信息
    public function getCourse(Request $request) {
        // TODO validate

        $courses = Course::where('id', $request->courseId)->first();
        if($courses) {
            return self::setResponse($courses, 200, 0);
        } else {
            return self::setResponse(null, 404, -4005);
        }
    }

    // 获取系统中所有的课程,同时获取其所拥有的 survey
    public function getAllCourse(Request $request) {
        $courses = Course::with(['belongsToUser', 'hasManySurveys'])->get(['id', 'teacher_id', 'name', 'intro', 'pic']);
        $courses = $courses->map(function($item, $key) {
            $teacher = $item->belongsToUser;
            $surveys = $item->hasManySurveys;
            $item['surveys'] = $surveys->map(function ($value) {
                return ['id' => $value->id, 'title' => $value->title];
            });
            $item['teacher'] = ['name' => $teacher->name, 'avatar' => $teacher->avatar];
            return $item;
        })->toArray();


        foreach ($courses as $key => $value) {
            array_forget($courses[$key], 'belongs_to_user');
            array_forget($courses[$key], 'has_many_surveys');
        } 
        return self::setResponse($courses, 200, 0);
    }
}
