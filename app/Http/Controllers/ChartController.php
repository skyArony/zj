<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Models\DB\Course;
use App\Models\DB\SurveyRecord;

class ChartController extends ApiController
{
  public function getSurveyRecord(Request $request) {
    $uid = auth('api')->parseToken()->payload()->get('sub');
    $startTime = intval($request->startTime) ? intval($request->startTime) / 1000 : time() - 7776000;
    $endTime = intval($request->endTime) ? intval($request->endTime) / 1000 : time();
    $courseId = intval($request->courseId);

    if (!$startTime || !$endTime ||!$courseId) {
      return self::setResponse(null, 400, -4004);
    }

    $course = Course::find($courseId);
    if ($course->teacher_id != $uid) return self::setResponse(null, 200, 0);

    $data = SurveyRecord::
            where("updated_at", ">=", Carbon::createFromTimestamp($startTime))->
            where("updated_at", "<=", Carbon::createFromTimestamp($endTime))->
            where("course_id", $courseId)->get();

    return self::setResponse($data, 200, 0);
  }
}
