<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client as GuzzleClient;


class LoginController extends ApiController
{
    use AuthenticatesUsers;

    protected $redirectUrl = '';

    // 获取当前登录的用户信息
    public function me(Request $request) {
        $uid = auth('api')->parseToken()->payload()->get('sub');
        if ($uid) {
            $user = User::where("id", $uid)->first();
            return self::setResponse($user, 200, 0);
        } else {
            return self::setResponse(null, 400, -4007);
        }
    }

    // 登陆方式一：账密方式登陆
    public function postLogin(Request $request){
        // 设置回调
        if($request->has("redirectUrl")) $this->redirectUrl = $request->redirectUrl;

        // 验证输入是否符合表单规则
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // 在模型 Login 中进行两次登陆验证
        $thirdStatus = Login::loginCheck($request->email, $request->password);

        if ($thirdStatus['code'] == 0) {
            // 校验通过，放行
            return $this->sendLoginResponse($request);
        } elseif ($thirdStatus['code'] == -4001) {
            // 用户改过密码，但是还是用旧密码在登录
            $this->guard()->logout();
            throw ValidationException::withMessages([
                $this->username() => '你近期修改过密码，请用新密码登录',
            ]);
        } elseif ($thirdStatus['code'] == -4002) {
            // 用户名或密码错误
            $this->guard()->logout();
            throw ValidationException::withMessages([
                $this->username() => "用户名或密码错误！",
            ]);
        } elseif ($thirdStatus['code'] == -4008) {
            // 用户名或密码错误
            $this->guard()->logout();
            throw ValidationException::withMessages([
                $this->username() => "大学城系统暂时不可用！",
            ]);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    // 注销
    public function postLogout()
    {
        Auth::logout();
        foreach ($_COOKIE as $key => $value) {
            setcookie($key, "", time()-3600, '/');
        }
        return redirect()->route('voyager.login');
    }

    // 登陆方式二：获取登陆 key
    public function loginKey(Request $request)
    {
        $uid = $request->uid;
        $user = User::find($uid);
        if ($user) {
            $key = md5(time() + rand(0, 10000));
            $user->login_key = $key;
            $user->save();
            return self::setResponse($key, 200, 0);
        } else {
            return self::setResponse(null, 404, -4005);
        }
    }

    // 登陆方式二：执行直接登陆
    public function loginKeyCheck(Request $request)
    {
        $uid = $request->uid;
        $user = User::find($uid);
        if ($user) {
            $key = $user->login_key;
            $worlduc_login = 'http://worlduc.com/index.aspx?op=Login&email=' . env("worlduc_email") . '&pass=' . env("worlduc_pass");
            $guzzleClient = new GuzzleClient(['cookies' => true]);
            $guzzleClient->request('POST', $worlduc_login, ['http_errors' => false]);
            $infoUrl = "http://worlduc.com/SpaceShow/UserInfo.aspx?uid=" . $uid;
            $response = $guzzleClient->request('GET', $infoUrl, ['http_errors' => false]);
            if ($response->getStatusCode() != 200) {
                return self::setResponse(null, 404, -4005);
            }
            $bodyInfo = $response->getBody()->getContents();
            preg_match('/<span class="ml10">(.*?)<\/span><\/li><\/ul>/', $bodyInfo, $matches);
            if ($matches && $matches[1] == $key) {
                $user = User::find($uid);
                // 到时候全换过来记得删
                // Cookie::queue('id', $uid, null, null, null, false, true);
                // Cookie::queue('role', $user->role_id, null, null, null, false, true);
                // 设置 JWT token
                $customClaims = ['role' => $user->role_id];
                $token = auth('api')->claims($customClaims)->tokenById($uid);
                Cookie::queue('token', $token);
                // 进行登陆
                if ($this->guard()->loginUsingId($uid)) return $this->sendLoginResponse($request);
                else {
                    return redirect('/admin/login?error=未知原因登陆失败!');
                }
            } else {
                return self::setResponse(null, 400, -4014);
            }
        } else {
            return self::setResponse(null, 404, -4005);
        }
    }

    // 回调：如果给定 redirectUrl 参数则跳转到指定路由,否则跳转到首页
    public function redirectTo()
    {
        if ($this->redirectUrl) {
            $url = $this->redirectUrl;
            return $url;
        }
        return config('voyager.user.redirect', route('voyager.dashboard'));
    }
}
