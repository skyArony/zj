<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\DB\SurveyRecord;
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

    public function bindSid(Request $request) {
        // TODO validate

        $sid = $request->sid;
        $uid = auth('api')->parseToken()->payload()->get('sub');

        $user = User::find($sid);

        // 如果以学号为 ID 进行查找,发现存在这样的用户,表示曾经以游客方式填过问卷
        if ($user) {
            $user = User::find($uid);
            if (!$user) return self::setResponse(null, 500, -5000);
            $user->sid = $sid;
            $user->save();

            // 修改历史问卷记录
            $surveyRecordList = SurveyRecord::where("creater_id", $sid)->get();
            foreach ($surveyRecordList as $surveyRecord) {
                $surveyRecord->creater_id = $uid;
                $surveyRecord->save();
            }

            // 修改历史班级加入记录
            $user = User::find($sid);
            $classList = $user->belongsToManyClasses;
            foreach ($classList as $class) {
                $class->belongsToManyUsers()->syncWithoutDetaching($uid);
            }

            User::destroy($sid);
        } else {
            $user = User::find($uid);
            if (!$user) return self::setResponse(null, 404, -4005);
            $user->sid = $sid;
            $user->save();
        }

        return self::setResponse(null, 200, 0);
    }
}
