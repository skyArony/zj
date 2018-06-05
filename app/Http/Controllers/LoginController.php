<?php

namespace App\Http\Controllers;

use App\Models\Login;
use Illuminate\Http\Request;

class LoginController extends ApiController
{
    // 登录检查
    public function loginCheck(Request $request){
        $data = Login::loginCheck($request->email, $request->pass);
        if($data == 0) return self::setResponse(null, 200, 0);
        else return self::setResponse(null, 400, $data);
    }

}
