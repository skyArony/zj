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
    public static function loginCheck($email, $pass)
    {
        $thirdCheck = self::thirdCheck($email, $pass);
        $myCheck = self::myCheck($email, $pass);

        // 大学城崩了的时候
        // if($myCheck) {
        //     return [
        //         "code" => 0,
        //         'msg' => $thirdCheck['msg'] . " | 大学城崩了,临时放行"
        //     ];
        // }

        // 通过
        if ($myCheck && $thirdCheck['code'] == 0) {
            return [
                "code" => 0,
                'msg' => $thirdCheck['msg'],
                "isXTU" => $thirdCheck['isXTU']
            ];
        }
        // 用户改了新密码
        elseif (!$myCheck && $thirdCheck['code'] == 0) {
            return [
                "code" => 0,
                'msg' => $thirdCheck['msg']
            ];
        }
        // 最近改过密码
        elseif ($myCheck && $thirdCheck['code'] == -2) {
            return [
                "code" => -4001,
                'msg' => $thirdCheck['msg']
            ];
        }
        // 密码错误
        elseif (!$myCheck && $thirdCheck['code'] == -2) {
            return [
                "code" => -4002,
                'msg' => $thirdCheck['msg']
            ];
        }
        // 大学城方面的错误
        elseif ($thirdCheck['code'] == -1) {
            return [
                "code" => -4008,
                'msg' => $thirdCheck['msg']
            ];
        }
    }

    // 第一步检查：自己数据库的账密
    protected static function myCheck($email, $pass)
    {
        if (Auth::guard()->attempt(['email' => $email, 'password' => $pass])) {
            return true;
        } else {
            return false;
        }
    }

    // 第二步检查：大学城登录
    protected static function thirdCheck($email, $pass)
    {
        $worlduc_login = 'http://worlduc.com/index.aspx?op=Login&email=' . $email . '&pass=' . $pass;
        $guzzleClient = new GuzzleClient(['cookies' => true]);
        $response = $guzzleClient->request('POST', $worlduc_login, ['http_errors' => false]);
        if ($response->getStatusCode() != 200) {
            return [
                "code" => -1,
                "msg" => $response->getStatusCode()
            ];
        }

        // 爬取用户基础信息
        $resJson = $response->getBody()->getContents();
        $resArr = json_decode($resJson, true);
        $cookieJar = serialize($guzzleClient->getConfig()['cookies']);

        if ($resArr['flag'] == 1) {
            // 获取用户身份
            $userInfoUrl = "http://worlduc.com/SpaceManage/Space/UserBase.aspx";
            $response = $guzzleClient->request('GET', $userInfoUrl, ['http_errors' => false]);
            if ($response->getStatusCode() != 200) {
                return [
                    "code" => -1,
                    "msg" => $response->getStatusCode()
                ];
            }
            $bodyInfo = $response->getBody()->getContents();
            preg_match('/<span id="ctl00_ContentPlaceHolderMain_ShenFen">(.*?)<\/span>/', $bodyInfo, $matches);
            if ($matches[1] == "学生") $role = 4;
            else if( $matches[1] == "教师") $role = 3;

            // 更新数据库
            if ($user = User::where('email', $email)->first()) {
                $user->id = $resArr['link1']['userid'];
                $user->avatar = 'http://www.worlduc.com'.$resArr['link1']['headpic'];
                $user->name = $resArr['link1']['username'];
                $user->password = Hash::make($pass);
                $user->org_id = $resArr['link2']['userid'];
                $user->org_avatar = 'http://www.worlduc.com'.$resArr['link2']['headpic'];
                $user->cookies = $cookieJar;
                $user->save();
            } else {
                $user = new User();
                $user->email = $email;
                $user->id = $resArr['link1']['userid'];
                $user->avatar = 'http://www.worlduc.com'.$resArr['link1']['headpic'];
                $user->name = $resArr['link1']['username'];
                $user->password = Hash::make($pass);
                $user->org_id = $resArr['link2']['userid'];
                $user->org_avatar = 'http://www.worlduc.com'.$resArr['link2']['headpic'];
                $user->role_id = $role;
                $user->cookies = $cookieJar;
                $user->save();
            }

            // 设置 JWT token
            $customClaims = ['role' => $user->role_id];
            $credentials = ['email' => $email, 'password' => $pass];
            $token = auth('api')->claims($customClaims)->attempt($credentials);
            Cookie::queue('token', $token, null, null, null, false, false);
            
            // 存储 email 到 cookies，部署完token后记得删除
            // Cookie::queue('id', $resArr['link1']['userid'], null, null, null, false, true);
            // Cookie::queue('role', $user->role_id, null, null, null, false, true);

            // 湘潭大学的学生返回一个额外的字段

            return [
                "code" => 0,
                "msg" => "success",
                "isXTU" => ($user->org_id == 1315555 && $user->sid == null && $user->role_id == 4) ? true : false
            ];
        } else {
            return [
                "code" => -2,
                "msg" => "fail"
            ];
        }
    }

}
