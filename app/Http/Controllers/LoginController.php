<?php

namespace App\Http\Controllers;

use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;


class LoginController extends ApiController
{
    use AuthenticatesUsers;

    // API: 登录检查：同时检查本身和大学城
    public function loginCheck(Request $request){
        $errcode = Login::loginCheck($request->email, $request->pass);
        if($errcode == 0) return self::setResponse(null, 200, 0);
        else return self::setResponse(null, 400, $errcode);
    }

    // session:登陆检查，并设置 cookie
    public function postLogin(Request $request){
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

        if ($thirdStatus == 0) {
            // 两次校验都通过，放行
            return $this->sendLoginResponse($request);
        } elseif ($thirdStatus == -4001) {
            // 用户改过密码，但是还是用旧密码在登陆
            $this->guard()->logout();
            throw ValidationException::withMessages([
                $this->username() => '你近期修改过密码，请用新密码登陆',
            ]);
        }  elseif ($thirdStatus == -4002) {
            // 用户名或密码错误
            $this->guard()->logout();
            throw ValidationException::withMessages([
                $this->username() => "用户名或密码错误！",
            ]);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function redirectTo()
    {
        return config('voyager.user.redirect', route('voyager.dashboard'));
    }

}
