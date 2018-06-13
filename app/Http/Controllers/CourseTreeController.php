<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\CourseTree;

class CourseTreeController extends Controller
{
    // 手动创建课程树信息

    // 自动爬取已有课程数信息

    // 给章节打 tag
    public function setTag(Request $request) {
        $tagSetInfoArr = $request->tagSetInfo;
        $courseId = $request->courseId;
        $chapterId = $request->chapterId;

        $courseTree = CourseTree::where("course_id", $courseId)->first();
        $courseTreeDataJson = $courseTree['data'];
        $courseTreeDataArr = json_decode($courseTree['data'], 1);

        foreach ($tagSetInfoArr as $key => $value) {
            $courseTreeDataArr[$chapterId][$key]['tags'] = $value;
        }

        $courseTree['data'] = json_encode($courseTreeDataArr);
        $courseTree->save();

        return self::setResponse($courseInfo, 200, 0);
    }
    
    // 给章节设置教学要求
    public function setReq(Request $request) {
        $reqSetInfoArr = $request->reqSetInfo;
        $courseId = $request->courseId;
        $chapterId = $request->chapterId;

        $courseTree = CourseTree::where("course_id", $courseId)->first();
        $courseTreeDataJson = $courseTree['data'];
        $courseTreeDataArr = json_decode($courseTree['data'], 1);

        foreach ($reqSetInfoArr as $key => $value) {
            $courseTreeDataArr[$chapterId][$key]['reqs'] = $value;
        }

        $courseTree['data'] = json_encode($courseTreeDataArr);
        $courseTree->save();

        return self::setResponse($courseInfo, 200, 0);
    }

}
