<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;
use App\User;
use App\Models\DB\Team;

class ResearchResultsController extends ApiController
{
    public function getTeamsByUserId() {
        // TODO validate

        if (Cookie::get('id')) $userId = Crypt::decrypt(Cookie::get('id'));
        else return self::setResponse(null, 400, -4007);    // 未登录

        $user = User::find($userId);
        $teams = $user->hasManyTeams()->get();
        return self::setResponse($teams, 200, 0);
    }

    public function getTasksByTeamId(Request $request) {
        // TODO validate

        if ($request->teamId) {
            $team = Team::find($request->teamId);
            $tasks = $team->belongsToManyTasks()->get();
            return self::setResponse($tasks, 200, 0);
        } else {
            return self::setResponse(null, 400, -4004);    // 未登录
        }
    }
}
