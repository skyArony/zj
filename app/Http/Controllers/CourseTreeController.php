<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\CourseTree;

class CourseTreeController extends ApiController
{
    // 手动创建课程树信息

    // 自动爬取已有课程数信息

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
