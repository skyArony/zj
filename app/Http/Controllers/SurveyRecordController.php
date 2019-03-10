<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\SurveyRecord;
use App\Models\DB\Course;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class SurveyRecordController extends ApiController
{
    // 新建一条记录
    public function addRecord(Request $request) {
        // TODO validata

        $sid = $request->sid;
        $name = $request->name;
        $isClass = $request->isClass;
        $courseId = $request->courseId;
        $tagIdList = json_encode($request->tags);
        $detail = json_encode($request->detail);

        if ($isClass) {
            // 如果是课堂问卷.登录了就取 uid, 没有登录就取填的学号
            if (auth('api')->check()) {
                $uid = auth('api')->parseToken()->payload()->get('sub');
            } elseif ($sid && $name) {
                // 如果没登陆
                if (User::find($sid)) {
                    $uid = $sid;
                } else {
                    $uid = $sid;
                    $user = new User();
                    $user->email = $sid . "@guest.temp";
                    $user->id = $sid;
                    $user->sid = $sid;
                    $user->avatar = 'http://www.worlduc.com/uploadImage/head/x0/default_1.jpg';
                    $user->name = $name;
                    $user->password = Hash::make("guestpass");
                    $user->org_id = "0000";
                    $user->org_avatar = 'http://www.worlduc.com/uploadImage/head/x0/default_1.jpg';
                    $user->role_id = 5;
                    $user->cookies = '';
                    $user->save();
                }
            }
        } else {
            // 如果不是课堂问卷,没有登录则直接返回,登陆了则取 uid
            if (!auth('api')->check()) return self::setResponse(false, 400, -4007);
            $uid = auth('api')->parseToken()->payload()->get('sub');
        }
        
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

        $sid = $request->sid;
        $name = $request->name;
        $isClass = $request->isClass;
        $courseId = $request->courseId;

        // 如果是课堂问卷
        if ($isClass) {
            // 如果学号和姓名都已经填写了,根据学号来判断是否填写过
            if ($sid && $name) {
                $uid = $sid;
            } else {
                // 登录态时根据本身状态来判断是否填写过,否则需要填写学号和姓名再判断
                if (!auth('api')->check()) return self::setResponse(-1, 200, 0);    // 未登录,返回-1提示要填写额外信息
                $uid = auth('api')->parseToken()->payload()->get('sub');
            }
            $SurveyRecord = SurveyRecord::where("creater_id", $uid)->where("course_id", $courseId)->get();
            if (count($SurveyRecord))
                return self::setResponse(true, 200, 0);
            else
                return self::setResponse(false, 200, 0);
        } else {
            // 如果不是课堂问卷
            if (!auth('api')->check()) return self::setResponse(false, 200, 0);    // 未登录
            $uid = auth('api')->parseToken()->payload()->get('sub');
            $SurveyRecord = SurveyRecord::where("creater_id", $uid)->where("course_id", $courseId)->get();
            if (count($SurveyRecord))
                return self::setResponse(true, 200, 0);
            else
                return self::setResponse(false, 200, 0);
        }
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
