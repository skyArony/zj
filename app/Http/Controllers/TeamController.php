<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\Team;
use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;

class TeamController extends ApiController
{
    // 获取系统中所有的 team
    public function getAllTeam() {
        $teams = Team::all();
        return self::setResponse($teams, 200, 0);
    }

    // 获取一个队伍的所有成员信息
    public function getAllMember(Request $request) {
        // TODO validate

        $teamId = $request->teamId;

        if ($team = Team::find($teamId)) {
            $leaderId = $team->creater_id;
            $leaderInfo = User::find($leaderId, ['id', 'name', 'phone', 'QQ', 'avatar']);
            $leaderInfo->isLeader = true;
            $members = $team->belongsToManyUsers();
            $membersId = $members->pluck('id')->toArray();
            $membersInfo = User::find($membersId, ['id', 'name', 'phone', 'QQ', 'avatar']);
            $membersInfo->prepend($leaderInfo);
            return self::setResponse($membersInfo, 200, 0);
        } else {
            return self::setResponse(null, 500, -4005);
        }
    }

    // 队伍报名一个课题
    public function signTask(Request $request) {
        // TODO validate

        if (Cookie::get('id')) $userId = Crypt::decrypt(Cookie::get('id'));
        else return self::setResponse(null, 400, -4007);    // 未登录

        $teamId = $request->teamId;
        $taskId = $request->taskId;

        $user = User::find($userId);
        $teams = $user->hasManyTeams()->pluck("id")->toArray();

        if (!in_array($teamId, $teams)) {
            return self::setResponse(null, 400, -4009);
        }

        if ($team = Team::find($teamId)) {
            $status = $team->belongsToManyTasks()->syncWithoutDetaching($taskId);
            return self::setResponse(null, 200, 0);
        } else {
            return self::setResponse(null, 500, -4005);
        }
    }
}
