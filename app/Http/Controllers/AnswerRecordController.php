<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\AnswerRecord;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class AnswerRecordController extends ApiController
{
    // 新建一条记录
    public function addRecord(Request $request) {
        // TODO validata

        if (Cookie::get('id')) {
            $userId = Crypt::decrypt(Cookie::get('id'));
        } else return self::setResponse(null, 400, -4007);    // 未登录

        $surveyId = $request->surveyId;
        $tags = json_encode($request->tags, JSON_UNESCAPED_UNICODE);

        $answerRecord = AnswerRecord::updateOrCreate(
            ['creater_id' => $userId],
            ['survey_id' => $surveyId, 'tags' => $tags]
        );
        if ($answerRecord) {
            return self::setResponse($answerRecord, 200, 0);
        } else {
            return self::setResponse(null, 400, -4006);
        }
    }

    // 查看一条记录-通过答卷 ID
    public function getRecord(Request $request) {
        // TODO validata

        if ($answerRecord = AnswerRecord::find($request->id)) 
            return self::setResponse($answerRecord, 200, 0);
        else 
            return self::setResponse(null, 404, -4005);
    }

    // 检查是否填写过问卷
    public function checkRecord(Request $request) {
        // TODO validate

        if (Cookie::get('id')) $userId = Crypt::decrypt(Cookie::get('id'));
        else return self::setResponse(null, 400, -4007);    // 未登录

        $answerRecord = AnswerRecord::where("id", $userId)->where("survey_id", $request->surveyId)->get();
        if (count($answerRecord))
            return self::setResponse(true, 200, 0);
        else
            return self::setResponse(false, 200, 0);
    }

    // 删除一个问卷填写记录
    public function delete(Request $request) {
        // TODO validate

        if (Cookie::get('id')) $userId = Crypt::decrypt(Cookie::get('id'));
        else return self::setResponse(null, 400, -4007);    // 未登录

        $surveyId = $request->surveyId;

        $ansRecIds = AnswerRecord::where('creater_id', $userId)->get(['id'])->toArray();

        $ids = [];
        foreach ($ansRecIds as $key => $value) {
            $ids[] = $value['id'];
        }
        if (!in_array($surveyId, $ids)) {
            return self::setResponse(null, 400, -4009);
        }

        AnswerRecord::find($surveyId)->delete();
        return self::setResponse(null, 200, 0);
    }
}
