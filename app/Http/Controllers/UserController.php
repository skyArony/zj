<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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
}
