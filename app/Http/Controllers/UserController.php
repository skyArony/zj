<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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

        if (Cookie::get('id')) $userId = Crypt::decrypt(Cookie::get('id'));
        else return self::setResponse(null, 400, -4007);    // 未登录

        $type = $request->type;

        if ($user = User::find($userId)) {
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

}
