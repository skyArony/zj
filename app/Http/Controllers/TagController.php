<?php

namespace App\Http\Controllers;

use App\Models\DB\Course;
use Illuminate\Http\Request;
use App\Models\DB\Tag;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class TagController extends ApiController
{
    // 新建 tag
    public function addTag(Request $request)
    {
        // TODO 增加validate,try catch

        $courseId = $request->courseId;
        $tag = $request->tag;

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $role = auth('api')->parseToken()->payload()->get('role');

        // 权限检验
        if ($role != 1) {
            $course = Course::where("id", $courseId)->first();
            if ($course->teacher_id != $uid) {
                return self::setResponse(null, 400, -4009);    // 越权操作  
            }
        }

        Tag::firstOrCreate(
                ['course_id' => $courseId, 'value' => $tag]
            );
        return self::setResponse(null, 200, 0);
    }

    // 删除 tag
    public function removeTag(Request $request)
    {
        // TODO 增加validate,try catch

        $courseId = $request->courseId;
        $tag = $request->tag;

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $role = auth('api')->parseToken()->payload()->get('role');

        // 权限检验
        if ($role != 1) {
            $course = Course::where("id", $courseId)->first();
            if ($course->teacher_id != $uid) return self::setResponse(null, 400, -4009);    // 越权操作  
        }

        // 删除 tag
        Tag::where("value", $tag)->where("course_id", $courseId)->delete();
        return self::setResponse(null, 200, 0);
    }

    // list all tags
    public function listTags(Request $request)
    {
        // TODO validate

        $courseId = $request->courseId;
        $tags = Tag::where("course_id", $courseId)->get(['value']);
        $data = array();
        foreach ($tags as $value) {
            $data[] =  $value->value;
        }
        return self::setResponse($data, 200, 0);
    }
}
