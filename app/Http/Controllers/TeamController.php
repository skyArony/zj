<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\Team;
use App\Models\DB\Task;
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

    // 获取一个 team 的信息
    public function getTeam(Request $request) {
        // TODO validate

        $teamId = $request->teamId;

        if ($team = Team::find($teamId)) {
            return self::setResponse($team, 200, 0);
        } else {
            return self::setResponse(null, 404, -4005);
        }
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
            return self::setResponse(null, 404, -4005);
        }
    }

    // 增加队伍的一个成员
    public function addMember(Request $request) {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $role = auth('api')->parseToken()->payload()->get('role');

        $memberId = $request->userId;
        $teamId = $request->teamId;
        $team = Team::find($teamId);

        // 权限检验
        if ($role != 1)
            if ($team->creater_id != $uid) return self::setResponse(null, 400, -4009);    // 越权操作   

        if ($team) {
            if ($team->creater_id == $memberId) {
                return self::setResponse(null, 400, -4010);
            }
            $team->belongsToManyUsers()->syncWithoutDetaching($memberId);
            return self::setResponse(null, 200, 0);
        } else {
            return self::setResponse(null, 404, -4012);
        }
    }

    // 删除队伍的一个成员
    public function deleteMember(Request $request) {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $role = auth('api')->parseToken()->payload()->get('role');

        $memberId = $request->userId;
        $teamId = $request->teamId;
        $team = Team::find($teamId);

        // 权限检验
        if ($role != 1)
            if ($team->creater_id != $uid) return self::setResponse(null, 400, -4009);    // 越权操作   

        if ($team) {
            if ($team->creater_id == $memberId) {
                return self::setResponse(null, 400, -4010);
            }
            if ($team->belongsToManyUsers()->detach($memberId)) {
                return self::setResponse(null, 200, 0);
            } else {
                return self::setResponse(null, 500, -4006);
            }
        } else {
            return self::setResponse(null, 404, -4012);
        } 
    }

    // 退出团队
    public function leaveTeam(Request $request) {
        // TODO validate
        $uid = auth('api')->parseToken()->payload()->get('sub');

        $teamId = $request->teamId;

        if ($team = Team::find($teamId)) {
            if ($team->creater_id == $uid) {
                return self::setResponse(null, 400, -4010);
            }
            if ($team->belongsToManyUsers()->detach($uid)) {
                return self::setResponse(null, 200, 0);
            } else {
                return self::setResponse(null, 500, -4006);
            }
        } else {
            return self::setResponse(null, 404, -4005);
        } 
    }

    // 队伍报名一个课题
    public function signTask(Request $request) {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $teamId = $request->teamId;
        $taskId = $request->taskId;

        $user = User::find($uid);
        $team = Team::find($teamId);
        $task = Task::find($taskId);

        if (!$team || !$task) return self::setResponse(null, 404, -4005);
        if ($team->creater_id != $user->id) return self::setResponse(null, 400, -4009);
        if ($task->regist_end_at < date("Y-m-d H:i:s")) return self::setResponse(null, 400, -4013);

        // 使用 attach 会报 sql 操作错误
        $team->belongsToManyTasks()->syncWithoutDetaching($taskId);
        return self::setResponse(null, 200, 0);
    }

    // 队伍退出一个课题
    public function leaveTask(Request $request) {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $teamId = $request->teamId;
        $taskId = $request->taskId;

        $user = User::find($uid);
        $teams = $user->hasManyTeams()->pluck("id")->toArray();

        if (!in_array($teamId, $teams)) {
            return self::setResponse(null, 400, -4009);
        }

        if ($team = Team::find($teamId)) {
            // 使用 attach 会报 sql 操作错误
            $team->belongsToManyTasks()->detach($taskId);
            return self::setResponse(null, 200, 0);
        } else {
            return self::setResponse(null, 404, -4005);
        }
    }

    // 删除一个队
    public function deleteTeam(Request $request) {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $teamId = $request->teamId;

        $user = User::find($uid);
        $teams = $user->hasManyTeams()->pluck("id")->toArray();

        if (!in_array($teamId, $teams)) {
            return self::setResponse(null, 400, -4009);
        }

        Team::find($teamId)->delete();
        return self::setResponse(null, 200, 0);
    }
}
