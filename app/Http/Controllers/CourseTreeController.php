<?php

namespace App\Http\Controllers;

use App\Models\DB\Course;
use Illuminate\Http\Request;
use App\Models\DB\CourseTree;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class CourseTreeController extends ApiController
{

    // 从数据库获取 courseTree 信息
    public function getCourseTree(Request $request) {
        // TODO validate

        $courseId = $request->courseId;
        $courseTree = CourseTree::where("course_id", $courseId)->first();
        $courseTreeDataJson = $courseTree['data'];
        $courseTreeDataArr = json_decode($courseTree['data'], 1);
        return self::setResponse($courseTreeDataArr, 200, 0);
    }

    // 更新 courseTree
    public function setCourseTree(Request $request) {
        // TODO validat

        $courseId = $request->courseId;

        // 登录检查
        if (Cookie::get('user_id') && Cookie::get('role')) {
            $userId = Crypt::decrypt(Cookie::get('user_id'));
            $role = Crypt::decrypt(Cookie::get('role'));
        } 
        else return self::setResponse(null, 400, -4007);    // 未登录

        // 权限检验
        if ($role != 1) {
            $course = Course::where("course_id", $courseId)->first();
            if ($course->teacher_id != $userId) return self::setResponse(null, 400, -4009);    // 越权操作
        }

        $courseTree = CourseTree::where("course_id", $courseId)->first();
        if ($courseTree) {
            $courseTree->data = json_encode($request->data) ;
            $courseTree->save();
            return self::setResponse($courseTree, 200, 0);
        } else {
            return self::setResponse(null, 400, -4005);
        }
        
    }

}
