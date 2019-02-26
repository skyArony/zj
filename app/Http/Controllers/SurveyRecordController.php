<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\SurveyRecord;
use App\Models\DB\Course;
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
        $detail = json_encode($request->detail);

        $SurveyRecord = SurveyRecord::updateOrCreate(
            ['creater_id' => $uid, 'course_id' => $courseId],
            [ 'tags' => $tagIdList, 'detail' => $detail]
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

    // 获取一个用户的所有填写记录
    public function getRecord(Request $request) {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $SurveyRecordList = SurveyRecord::where("creater_id", $uid)->get();
        foreach($SurveyRecordList as $key=>$SurveyRecord) {
            $SurveyRecordList[$key]['course'] = Course::find($SurveyRecord->course_id)->name;
            $SurveyRecordList[$key]['score'] = (json_decode($SurveyRecord->detail))->totalScore;
        }
        return self::setResponse($SurveyRecordList, 200, 0);
    }

    // 删除一个问卷填写记录
    public function deleteRecord(Request $request) {
        // TODO validate

        $surveyId = $request->surveyId;
        SurveyRecord::find($surveyId)->delete();

        if (SurveyRecord::find($surveyId)) {
            return self::setResponse(null, 400, -4006);
        } else {
            return self::setResponse(null, 200, 0);
        }
    }
}
