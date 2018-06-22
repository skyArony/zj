<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\Tag;

class TagController extends ApiController
{
    // 新建 tag
    public function addTag(Request $request) {
        // TODO 增加validate,try catch

        $courseId = $request->courseId;
        $tags = $request->tags;

        foreach ($tags as $value) {
            Tag::firstOrCreate(
                ['course_id' => $courseId, 'value' => $value."-easy"]
            );
            Tag::firstOrCreate(
                ['course_id' => $courseId, 'value' => $value."-normal"]
            );
            Tag::firstOrCreate(
                ['course_id' => $courseId, 'value' => $value."-hard"]
            );
        }
        return self::setResponse(null, 200, 0);
    }

    // 删除 tag
    public function removeTag(Request $request) {
        // TODO 增加validate,try catch

        $courseId = $request->courseId;
        $tags = $request->tags;

        foreach ($tags as $value) {
            // 删除 tag
            Tag::where("value", "like", "$value-%")->where("course_id", $courseId)->delete();
        }
        return self::setResponse(null, 200, 0);
    }

    // list all tags
    public function listTags(Request $request) {
        // TODO validate

        $courseId = $request->courseId;
        $tags = Tag::where("course_id", $courseId)->get();
        $tagName = array();
        foreach ($tags as $value) {
            $tagName[] =  explode('-', $value->value)[0];
        }

        $data = json_encode(array_values(array_unique($tagName)));
        return self::setResponse($data, 200, 0);
    }

}
