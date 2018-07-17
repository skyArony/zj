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
        $survey->creater_id = Crypt::decrypt(Cookie::get('teacher_id'));
        $survey->creater = Crypt::decrypt(Cookie::get('name'));
        $survey->course = $request->course;
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

    // 查看制定问卷的数据
    public function getSurvey(Request $request) {
        // TODO validate

        if ($survey = Survey::find($request->id)) 
            return self::setResponse($survey, 200, 0);
        else 
            return self::setResponse(null, 400, -4005);
    }

    // 新建问题
    public function addQuestion(Request $request)
    {
        // TODO validate

        $question = new Question;
        $question->desc = $request->desc;
        $question->survey_id = $request->surveyId;
        $question->isMulti = $request->isMulti;
        $question->option = $request->option;
        $question->save();

        return self::setResponse($question, 200, 0);
    }

    // 修改问题
    public function updateQuestion(Request $request)
    {
        // TODO validate

        $question = Question::find($request->id);
        $question->desc = $request->desc;
        $question->isMulti = $request->isMulti;
        $question->option = $request->option;
        $question->save();

        return self::setResponse($question, 200, 0);
    }

    // 删除问题
    public function deleteQuestion(Request $request)
    {
        // TODO validate

        Question::find($request->id)->delete();

        return self::setResponse(null, 200, 0);
    }

    // 查看所有的问题
    public function listQuestion(Request $request)
    {
        $questions = Question::all();
        return self::setResponse($questions, 200, 0);
    }
}
