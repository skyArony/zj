<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\SurveyRecord;
use App\Models\DB\Survey;
use App\Models\DB\Course;
use App\Models\DB\Tag;

class CustomCourseController extends ApiController
{
    // 查看一条记录-通过答卷 ID
    public function getCustomCourseById(Request $request) {
        // TODO validate

        // SurveyRecord 获取
        $SurveyRecord = SurveyRecord::find($request->recordId);
        if (!$SurveyRecord) return self::setResponse(null, 404, -4005);

        // 课程信息获取
        $courseId = $SurveyRecord->course_id;
        $course = Course::find($courseId);
        $teacher = $course->belongsToUser;
        $courseName = $course->name;
        $courseDesc = $course->intro;
        $courseImg = $course->pic;
        $courseTeacher = $teacher->name;
        $courseId = $course->id;
        $courseTree = json_decode($course->hasOneCourseTree->data, 1);   // 课程树目录

        // tag 信息获取
        $tags = json_decode($SurveyRecord->tags, 1);
        $courseTags = Tag::where("course_id", $courseId)->get();
        $courseTagsArr = array();
        foreach ($courseTags as $value) {
            $courseTagsArr[$value->id] = $value->value;
        }
        $tagsArr = array();
        foreach ($tags as $value) {
            $tagsArr[] = $courseTagsArr[$value];
        }

        // 需要选择性展示的 tree 和 target 处理
        foreach ($courseTree as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if ($key2 == 'chapter_name') {
                    continue;
                }
                if (isset($value2['tags'])) {
                    if (array_intersect($value2['tags'], $tagsArr)) {
                        $courseTree[$key][$key2]["status"] = true;
                        $courseTree[$key]["status"] = true;
                    } else {
                        $courseTree[$key][$key2]["status"] = false;
                        $courseTree[$key]["status"] = false;
                    }
                } else {
                    $courseTree[$key][$key2]["status"] = false;
                    $courseTree[$key]["status"] = false;
                }
            }
        }

        $courseTreeFilter = $this->treeData($courseTree);
        $courseTargetFilter = $this->targetData($courseTree);

        $data = [
            'courseId' => $courseId,
            'courseName' => $courseName,
            'courseDesc' => $courseDesc,
            'courseImg' => $courseImg,
            'courseTeacher' => $courseTeacher,
            'surveyRecordTags' => $tagsArr,
            'courseTree' => $courseTree,
            'courseTreeFilter' => $courseTreeFilter,
            'courseTargetFilter' => $courseTargetFilter,
        ];

        return self::setResponse($data, 200, 0);
    }


    // 获取一个定制化课程信息
    public function getCustomCourse(Request $request)
    {
        // TODO validate
        $uid = auth('api')->parseToken()->payload()->get('sub');

        // SurveyRecord 获取
        $SurveyRecord = SurveyRecord::where("creater_id", $uid)->where("course_id", $request->courseId)->first();
        if (!$SurveyRecord) return self::setResponse(null, 404, -4005);

        // 课程信息获取
        $courseId = $request->courseId;
        $course = Course::find($courseId);
        $teacher = $course->belongsToUser;
        $courseName = $course->name;
        $courseDesc = $course->intro;
        $courseImg = $course->pic;
        $courseTeacher = $teacher->name;
        $courseId = $course->id;
        $courseTree = json_decode($course->hasOneCourseTree->data, 1);   // 课程树目录

        // tag 信息获取
        $tags = json_decode($SurveyRecord->tags, 1);
        $courseTags = Tag::where("course_id", $courseId)->get();
        $courseTagsArr = array();
        foreach ($courseTags as $value) {
            $courseTagsArr[$value->id] = $value->value;
        }
        $tagsArr = array();
        foreach ($tags as $value) {
            $tagsArr[] = $courseTagsArr[$value];
        }
        var_dump($SurveyRecord->toArray());
        var_dump('--------');
        var_dump($tags);
        var_dump('--------');

        // 需要选择性展示的 tree 和 target 处理
        foreach ($courseTree as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if ($key2 == 'chapter_name') {
                    continue;
                }
                if (isset($value2['tags'])) {
                    var_dump($value2['tags']);
                    var_dump($tagsArr);
                    if (array_intersect($value2['tags'], $tagsArr)) {
                        $courseTree[$key][$key2]["status"] = true;
                        $courseTree[$key]["status"] = true;
                    } else {
                        $courseTree[$key][$key2]["status"] = false;
                        $courseTree[$key]["status"] = false;
                    }
                } else {
                    $courseTree[$key][$key2]["status"] = false;
                    $courseTree[$key]["status"] = false;
                }
            }
        }

        $courseTreeFilter = $this->treeData($courseTree);
        $courseTargetFilter = $this->targetData($courseTree);

        $data = [
            'courseId' => $courseId,
            'courseName' => $courseName,
            'courseDesc' => $courseDesc,
            'courseImg' => $courseImg,
            'courseTeacher' => $courseTeacher,
            'surveyRecordTags' => $tagsArr,
            'courseTree' => $courseTree,
            'courseTreeFilter' => $courseTreeFilter,
            'courseTargetFilter' => $courseTargetFilter,
        ];

        return self::setResponse($data, 200, 0);
    }

    //  计算课程树
    protected function treeData($data)
    {
        $res = [];
        foreach ($data as $key => $value) {
            if ($value['status']) {
                $children = [];
                foreach ($value as $key2 => $value2) {
                    if ($key2 != "chapter_name" && $key2 != "status") {
                        if ($value2['status']) {
                            $obj2 = [
                                "id" => $key2,
                                "label" => $value2['period_title']
                            ];
                            $children[] = $obj2;
                        }
                    }
                }
                $res[] = [
                    "id" => $key,
                    "label" => $value['chapter_name'],
                    "children" => $children
                ];
            }
        }
        return $res;
    }

    //  计算课程目标
    protected function targetData($data)
    {
        $res = [];
        foreach ($data as $key => $value) {
            if ($value['status']) {
                $children = [];
                foreach ($value as $key2 => $value2) {
                    if ($key2 != "chapter_name" && $key2 != "status") {
                        if ($value2['status']) {
                            $obj2 = [
                                "id" => $key2,
                                "label" => $value2['period_title'],
                                "children" => $value2['claims']
                            ];
                            $children[] = $obj2;
                        }
                    }
                }
                $res[] = [
                    "id" => $key,
                    "label" => $value['chapter_name'],
                    "children" => $children
                ];
            }
        }
        return $res;
    }
}
