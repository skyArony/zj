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

        // 登录检查
        if (Cookie::get('user_id') && Cookie::get('role')) {
            $userId = Crypt::decrypt(Cookie::get('user_id'));
            $role = Crypt::decrypt(Cookie::get('role'));
        } 
        else return self::setResponse(null, 400, -4007);    // 未登录

        // 权限检验
        if ($role != 1) {
            $course = Course::where("course_id", $courseId)->first();
            if ($course->teacher_id != $userId) {
                return self::setResponse(null, 400, -4009);    // 越权操作  
            }
        }

        Tag::firstOrCreate(
                ['course_id' => $courseId, 'value' => $tag."-easy"]
            );
        Tag::firstOrCreate(
                ['course_id' => $courseId, 'value' => $tag."-normal"]
            );
        Tag::firstOrCreate(
                ['course_id' => $courseId, 'value' => $tag."-hard"]
            );
        return self::setResponse(null, 200, 0);
    }

    // 删除 tag
    public function removeTag(Request $request)
    {
        // TODO 增加validate,try catch

        $courseId = $request->courseId;
        $tag = $request->tag;

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

        // 删除 tag
        Tag::where("value", "like", "$tag-%")->where("course_id", $courseId)->delete();
        return self::setResponse(null, 200, 0);
    }

    // list all tags
    public function listTags(Request $request)
    {
        // TODO validate

        $courseId = $request->courseId;
        $tags = Tag::where("course_id", $courseId)->get();
        $tagName = array();
        foreach ($tags as $value) {
            $tagName[] =  explode('-', $value->value)[0];
        }

        $data = array_values(array_unique($tagName));
        return self::setResponse($data, 200, 0);
    }
}
