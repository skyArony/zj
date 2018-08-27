<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\Team;
use App\User;

class TeamController extends ApiController
{
    // 获取系统中所有的 task
    public function getAllTeam() {
        $teams = Team::all();
        return self::setResponse($teams, 200, 0);
    }

    // 获取一个队伍的所有成员信息
    public function getAllMember(Request $request) {
        // TODO validate

        $teamId = $request->teamId;
        $membersId = [];

        if ($team = Team::find($teamId)) {
            $leaderId = $team->creater_id;
            $members = $team->belongsToManyUsers();
            $membersId = $members->pluck('id')->toArray();
            array_unshift($membersId, $leaderId);
            $membersInfo = User::find($membersId, ['id', 'name', 'phone', 'QQ', 'avatar']);
            return self::setResponse($membersInfo, 200, 0);
        } else {
            return self::setResponse(null, 500, -4005);
        }
    }
}
