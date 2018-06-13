<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class Login extends Model
{
    // 登录检查,同时检查自身和大学城
    public static function loginCheck($email, $pass){
        $thirdCheck = self::thirdCheck($email, $pass);
        $myCheck = self::myCheck($email, $pass);

        // 通过
        if($myCheck && $thirdCheck) return 0;
        // 用户改了新密码
        elseif (!$myCheck && $thirdCheck) return 0;
        // 最近改过密码
        elseif($myCheck && !$thirdCheck) return -4001;
        // 密码错误
        elseif(!$myCheck && !$thirdCheck) return -4002;
    }

    // 第一步检查：自己数据库的账密
    protected static function myCheck($email, $pass){
        if (Auth::guard()->attempt(['email' => $email, 'password' => $pass])) {
            return true;
        } else {
            return false;
        }
    }

    // 第二步检查：大学城登陆
    protected static function thirdCheck($email, $pass){
        $worlduc_login = 'http://worlduc.com/index.aspx?op=Login&email=' . $email . '&pass=' . $pass;
        $guzzleClient = new GuzzleClient(['cookies' => true]);
        $response = $guzzleClient->request('POST', $worlduc_login);
        $resJson = $response->getBody()->getContents();
        $resArr = json_decode($resJson, true);
        // 模拟登陆的到的 cookies
       $cookieJar = serialize($guzzleClient->getConfig()['cookies']);

        if($resArr['flag'] == 1) {
            // 更新数据库
            $flight = User::updateOrCreate(
                ['email' => $email], [
                    'user_id' => $resArr['link1']['userid'],
                    'avatar' => 'http://www.worlduc.com'.$resArr['link1']['headpic'],
                    'name' => $resArr['link1']['username'],
                    'password' => Hash::make($pass),
                    'org_id' => $resArr['link2']['userid'],
                    'org_avatar' => 'http://www.worlduc.com'.$resArr['link2']['headpic'],
                    'role_id' => 1,
                    'cookies' => $cookieJar
                ]
            );
            // 存储 email 到 cookies
            Cookie::queue('email', $email);
            return true;
        } else return false;
    }

}
