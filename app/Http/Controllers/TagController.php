<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\Tag;

class TagController extends Controller
{
    // 新建 tag
    public function addTag(Request $request) {
        // TODO 增加validate,try catch

        $courseId = $request->courseId;
        $tags = $request->tags;

        $tags = explode(',', $tags);
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
        $res = Tag::where("value", "like", "$value-%");
        return self::setResponse($res, 200, 0);
    }

    // 删除 tag
    public function removeTag(Request $request) {
        // TODO 增加validate,try catch

        $courseId = $request->courseId;
        $tag = $request->tag;

        // 删除 tag
        Tag::where("value", "like", "$tag-%")->delete();

        return self::setResponse(null, 200, 0);
    }

}
