<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\DB\AnswerRecord;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;

class UserController extends ApiController
{
    public function search(Request $request) {
        // TODO validate

        $keyword = $request->keyword;
        $type = $request->type;

        if($type == 'id') {
            $user = User::find($keyword, ['id', 'name', 'phone', 'QQ', 'avatar']);
            if ($user) return self::setResponse([$user], 200, 0);
            else return self::setResponse([], 200, 0);
        } else if ($type == 'name') {
            if (!$keyword) return self::setResponse(null, 400, -4011);
            $users = User::where("name", "like", "%$keyword%")->get(['id', 'name', 'phone', 'QQ', 'avatar']);
            return self::setResponse($users, 200, 0);
        }
    }

    // 绑定 QQ 和手机号
    public function bindContact(Request $request) {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $type = $request->type;

        if ($user = User::find($uid)) {
            if ($type == 'tel') {
                $user->phone = $request->phone;
            } else if ($type == 'qq') {
                $user->QQ = $request->qq;
            }
            if($user->save()) {
                return self::setResponse(null, 200, 0);
            } else {
                return self::setResponse(null, 500, -4006);
            }
        } else {
            return self::setResponse(null, 404, -4005);
        }
    }
    
    // 获取一个用户的问卷填写记录
    public function getAnswerRecord() {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $ansRecs = AnswerRecord::with('belongsToSurvey.belongsToCourse')->where('creater_id', $uid)->get();
        $ansRecs = $ansRecs->map(function ($item) {
            $res = [];
            $res['id'] = $item->id;
            $res['survey'] = $item->belongsToSurvey->title;
            $res['course'] = $item->belongsToSurvey->belongsToCourse->name;
            $res['updated_at'] = date("Y-m-d H:i:s", strtotime($item->updated_at));
            return $res;
        });
        return self::setResponse($ansRecs, 200, 0);
    }

    // 获取一个用户参与的所有团队
    public function getMyTeams() {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');
        if ($user = User::with('belongsToManyTeams.belongsToManyUsers')->find($uid)) {
            // 自己作为队员的组
            $teams = $user->belongsToManyTeams;
            $teams = $teams->map(function ($item) {
                $res = [];
                $res['id'] = $item->id;
                $res['avatar'] = $item->avatar;
                $res['team'] = $item->team_name;
                $res['desc'] = $item->team_desc;
                $res['avatar'] = $item->avatar;
                $res['memberNum'] = $item->belongsToManyUsers->count() + 1;
                $res['leader'] = $item->belongsToUser->name;
                $res['isLeader'] = false;
                return $res;
            });

            // 自己作为队长的组
            $user = User::with('hasManyTeams.belongsToManyTasks.belongsToUser')->find($uid);
            $teams2 = $user->hasManyTeams;
            $teams2 = $teams2->map(function ($item) use($user) {
                $res = [];
                $res['id'] = $item->id;
                $res['avatar'] = $item->avatar;
                $res['team'] = $item->team_name;
                $res['desc'] = $item->team_desc;
                $res['avatar'] = $item->avatar;
                $res['memberNum'] = $item->belongsToManyUsers->count() + 1;
                $res['leader'] = $user->name;
                $res['isLeader'] = true;
                return $res;
            });

            // 去除空元素,化为一维
            $teamsArray = array_merge($teams->toArray(), $teams2->toArray());
            return self::setResponse($teamsArray, 200, 0);
        } else {
            return self::setResponse(null, 404, -4005);
        }
    }

    // public function test() {
    //     return self::setResponse($_SERVER, 200, 0);
    // }
}
