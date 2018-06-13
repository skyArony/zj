<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\Question;

class QuestionController extends Controller
{
    // 新建问题
    public function addQuestion(Request $request) {
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
    public function updateQuestion(Request $request) {
        // TODO validate

        $question = Question::find($request->id);
        $question->desc = $request->desc;
        $question->isMulti = $request->isMulti;
        $question->option = $request->option;
        $question->save();

        return self::setResponse($question, 200, 0);
    }

    // 删除问题
    public function deleteQuestion(Request $request) {
        // TODO validate

        Question::find($request->id)->delete();

        return self::setResponse(null, 200, 0);
    }

    // 查看所有的问题
    public function listQuestion(Request $request) {
        $questions = Question::all();
        return self::setResponse($questions, 200, 0);
    }

}
