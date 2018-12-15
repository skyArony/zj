<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;
use App\User;
use App\Models\DB\Team;
use App\Models\DB\Task;
use App\Models\DB\ResearchResult;

class ResearchResultsController extends ApiController
{
    public function getTeamsByUserId() {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');

        $user = User::find($uid);
        $teams = $user->hasManyTeams()->get();
        return self::setResponse($teams, 200, 0);
    }

    public function getTasksByTeamId(Request $request) {
        // TODO validate

        if ($request->teamId) {
            $team = Team::find($request->teamId);
            $tasks = $team->belongsToManyTasks;
            $tasks = $tasks->filter(function($item) {
                if ($item->submit_end_at >= date("Y-m-d H:i:s")) return true;
            });
            return self::setResponse($tasks, 200, 0);
        } else {
            return self::setResponse(null, 400, -4004);    // 未登录
        }
    }

    public function getResults(Request $request) {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');
        
        if ($user = User::with('belongsToManyTeams')->find($uid)) {
            // 自己作为队员的组
            $teams = $user->belongsToManyTeams;
            $ids = $teams->pluck('id');

            // 自己作为队长的组
            $user = User::with('hasManyTeams')->find($uid);
            $teams2 = $user->hasManyTeams;
            $ids2 = $teams2->pluck('id');

            $allTeamId = array_merge($ids->toArray(), $ids2->toArray());
            $results = ResearchResult::whereIn('team_id', $allTeamId)->get(['title', 'team_id', 'task_id', 'created_at', 'id']);

            $results = $results->map(function($item) {
                $item->team = Team::find($item->team_id, ['team_name'])->team_name;
                $item->task = Task::find($item->task_id, ['title'])->title;
                return $item;
            });
            return self::setResponse($results, 200, 0);
        } else {
            return self::setResponse(null, 404, -4005);
        }

        $results = ResearchResult::all();
    }

    public function getResultDetail(Request $request) {
        // TODO validate

        $resultId = $request->resultId;
        
        if ($result = ResearchResult::find($resultId)) {
            $result->team = Team::find($result->team_id, ['team_name'])->team_name;
            $result->task = Task::find($result->task_id, ['title'])->title;
            return self::setResponse($result, 200, 0);
        } else {
            return self::setResponse(null, 404, -4005);
        }
    }
}
