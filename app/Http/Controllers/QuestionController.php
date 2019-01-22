<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\Question;
use App\Models\DB\Course;

class QuestionController extends ApiController
{
    // 题库添加新题
    public function addQuestion(Request $request)
    {
        // TODO  validate

        $question = new Question;
        $question->title = $request->title;
        $question->option = $request->option;
        $question->type = $request->type;
        $question->level = $request->level;
        $question->tag_id = $request->tag_id;
        $question->option = json_encode($request->option, JSON_UNESCAPED_UNICODE);
        $question->answer = json_encode($request->answer, JSON_UNESCAPED_UNICODE);
        if ($question->save()) {
            return self::setResponse($question, 200, 0);
        } else {
            return self::setResponse(null, 400, -4006);
        }
    }

    // 根据课程 ID 返回所以的题
    public function getQuestionsByCourseId(Request $request)
    {
      // TODO validate

      $courseId = $request->courseId;
      $course = Course::find($courseId);

      $questions = $course->hasManyQuestionsThroughTag();
      return self::setResponse($questions->get(), 200, 0);
    }

    // 根据问题 ID 删除问题
    public function deleteQuestionById(Request $request)
    {
      // TODO validate

      $questionId = $request->questionId;
      if (Question::destroy($questionId)) {
        return self::setResponse(null, 200, 0);
      } else {
        return self::setResponse(null, 400, -4006);
      }
    }
}
