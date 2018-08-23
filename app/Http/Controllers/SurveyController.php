<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\Question;
use App\Models\DB\Survey;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;


class SurveyController extends ApiController
{
    // 新建问卷
    public function addSurvey(Request $request)
    {
        // TODO  validate

        $survey = new Survey;
        $survey->title = $request->title;
        $survey->desc = $request->desc;
        $survey->course_id = $request->course_id;
        $survey->creater_id = Crypt::decrypt(Cookie::get('id'));
        $survey->questions = json_encode($request->questions, JSON_UNESCAPED_UNICODE);
        if ($survey->save()) {
            return self::setResponse($survey, 200, 0);
        } else {
            return self::setResponse(null, 500, -4006);
        }
    }

    // 修改问卷
    public function updateSurvey(Request $request) {
        // TODO validate

        // 登录检查
        if (Cookie::get('id') && Cookie::get('role')) {
            $userId = Crypt::decrypt(Cookie::get('id'));
            $role = Crypt::decrypt(Cookie::get('role'));
        } 
        else return self::setResponse(null, 400, -4007);    // 未登录

        // 权限检验
        if ($role != 1) {
            $survey = Survey::where("id", $request->id)->first();
            if ($survey->creater_id != $userId) return self::setResponse(null, 400, -4009);    // 越权操作    
        }
        
        $survey = Survey::find($request->id);
        $survey->title = $request->title;
        $survey->desc = $request->desc;
        $survey->questions = json_encode($request->questions, JSON_UNESCAPED_UNICODE);
        if ($survey->save()) {
            return self::setResponse($survey, 200, 0);
        } else {
            return self::setResponse(null, 500, -4006);
        }
    }

    // 查看指定问卷的数据
    public function getSurvey(Request $request) {
        // TODO validate

        if ($survey = Survey::find($request->id)) 
            return self::setResponse($survey, 200, 0);
        else 
            return self::setResponse(null, 400, -4005);
    }
}
