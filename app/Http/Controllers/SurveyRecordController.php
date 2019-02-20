<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\SurveyRecord;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class SurveyRecordController extends ApiController
{
    // 新建一条记录
    public function addRecord(Request $request) {
        // TODO validata

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $courseId = $request->courseId;
        $tagIdList = json_encode($request->tags);

        $SurveyRecord = SurveyRecord::updateOrCreate(
            ['creater_id' => $uid],
            ['course_id' => $courseId, 'tags' => $tagIdList]
        );
        if ($SurveyRecord) {
            return self::setResponse($SurveyRecord, 200, 0);
        } else {
            return self::setResponse(null, 400, -4006);
        }
    }

    // // 查看一条记录-通过答卷 ID
    // public function getRecord(Request $request) {
    //     // TODO validata

    //     if ($SurveyRecord = SurveyRecord::find($request->id)) 
    //         return self::setResponse($SurveyRecord, 200, 0);
    //     else 
    //         return self::setResponse(null, 404, -4005);
    // }

    // 检查是否填写过问卷
    public function checkRecord(Request $request) {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');

        $SurveyRecord = SurveyRecord::where("creater_id", $uid)->where("course_id", $request->courseId)->get();
        if (count($SurveyRecord))
            return self::setResponse(true, 200, 0);
        else
            return self::setResponse(false, 200, 0);
    }

    // // 删除一个问卷填写记录
    // public function delete(Request $request) {
    //     // TODO validate

    //     $uid = auth('api')->parseToken()->payload()->get('sub');
    //     $surveyId = $request->surveyId;
    //     $ansRecIds = SurveyRecord::where('creater_id', $uid)->get(['id'])->toArray();

    //     $ids = [];
    //     foreach ($ansRecIds as $key => $value) {
    //         $ids[] = $value['id'];
    //     }
    //     if (!in_array($surveyId, $ids)) {
    //         return self::setResponse(null, 400, -4009);
    //     }

    //     SurveyRecord::find($surveyId)->delete();
    //     return self::setResponse(null, 200, 0);
    // }
}
