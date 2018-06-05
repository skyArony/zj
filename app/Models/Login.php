<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use App\User;
use Illuminate\Support\Facades\Hash;

class Login extends Model
{
    // 登录检查
    public static function loginCheck($email, $pass){
        $res = self::thirdCheck($email, $pass);
        $myCheck = self::myCheck($email, $pass);
        $thirdCheck = ($res->flag == 1) ? true : false;

        if($myCheck && $thirdCheck) return 0;
        elseif($myCheck && !$thirdCheck) return -4001;
        elseif(!$myCheck && !$thirdCheck) return -4002;
        elseif (!$myCheck && $thirdCheck) {
            // 更新数据库密码
            $user = User::updateOrCreate(
                ['email' => $email], [
                    'user_id' => $res->link1->userid,
                    'name' => $res->link1->username,
                    'user_avatar' => 'http://www.worlduc.com'.$res->link1->headpic,
                    'org_id' => $res->link2->userid,
                    'org_avatar' => 'http://www.worlduc.com'.$res->link2->headpic,
                    'password' => Hash::make($pass),
                ]
            );
            return 0;
        }
    }

    // 第一步检查：自己数据库的账密
    public static function myCheck($email, $pass){
        if (Auth::attempt(['email' => $email, 'password' => $pass])) {
            return true;
        } else {
            return false;
        }
    }

    // 第二步检查：大学城登录检查
    public static function thirdCheck($email, $pass){
        $worlduc_login = 'http://worlduc.com/index.aspx';
        $guzzleClient = new GuzzleClient();

        $response = $guzzleClient->request('POST', $worlduc_login, [
            'form_params' => [
                'op' => 'Login',
                'email' => $email,
                'pass' => $pass
            ]
        ]);

        $response = $response->getBody()->getContents();

        return json_decode($response);
    }
}
