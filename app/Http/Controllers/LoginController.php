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


class LoginController extends ApiController
{
    use AuthenticatesUsers;

    protected $redirectUrl = '';

    // 获取当前登录的用户信息
    public function me(Request $request) {
        if (Cookie::get('id')) {
            $id = Crypt::decrypt(Cookie::get('id'));
            $user = User::where("id", $id)->first();
            return self::setResponse($user, 200, 0);
        } else {
            return self::setResponse(null, 400, -4007);
        }
    }

    // session方式: 登录，并设置 cookie
    public function postLogin(Request $request){
        // 设置回调
        if($request->has("redirectUrl")) $this->redirectUrl = $request->redirectUrl;

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->credentials($request);
        $thirdStatus = Login::loginCheck($request->email, $request->password);

        if ($thirdStatus['code'] == 0) {
            // 校验通过，放行

            // 设置 token
            // $customClaims = ['email' => $request->email];
            // $credentials = request(['email', 'password']);
            // $token = auth('api')->claims($customClaims)->attempt($credentials);
            // Cookie::queue('token', $token);

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

    // 回调：如果给定 redirectUrl 参数则跳转到指定路由,否则跳转到首页
    public function redirectTo()
    {
        if ($this->redirectUrl) {
            $url = env('APP_URL').$this->redirectUrl;
            return $url;
        }
        return config('voyager.user.redirect', route('voyager.dashboard'));
    }

}
