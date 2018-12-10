<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\DB\QQ;
use Illuminate\Http\Request;
use Overtrue\Socialite\SocialiteManager;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class SocialiteController extends ApiController
{
    use AuthenticatesUsers;

    public $config;
    public $socialite;

    public function __construct()
    {
        $this->config = [
            'qq' => [
                'client_id'     => env('client_id_qq'),
                'client_secret' => env('client_secret_qq'),
                'redirect'      => env('APP_URL').'/socialite/callback',
            ],
        ];

        $this->socialite = new SocialiteManager($this->config);
    }

    public function bindQQ(Request $request)
    {
        if (Cookie::get('id')) {
            $userId = Cookie::get('id');
        } else {
            header("location: " . env('APP_URL'));
        }
        $this->config['qq']['redirect'] = env('APP_URL').'/socialite/callback?action=bind';
        $this->socialite = new SocialiteManager($this->config);
        $response = $this->socialite->driver('qq')->redirect();
        $response->send();
    }

    public function loginQQ(Request $request)
    {
        $this->config['qq']['redirect'] = env('APP_URL').'/socialite/callback?action=login';
        $this->socialite = new SocialiteManager($this->config);
        $response = $this->socialite->driver('qq')->redirect();
        $response->send();
    }


    public function callback(Request $request)
    {
        $userInfo = $this->socialite->driver('qq')->user();
        if ($request->action == 'bind') {
            $userId = Cookie::get('id');
            $item = QQ::updateOrCreate(
              ['qq_id' => $userInfo['id']],
              ['user_id' => $userId, 'user_info' => json_encode($userInfo, JSON_UNESCAPED_UNICODE)]
            );
            return redirect("/#/index/me");
        } elseif ($request->action == 'login') {
            $item = QQ::find($userInfo['id']);
            if (!$item) {
                $this->guard()->logout();
                // throw ValidationException::withMessages([
                //   $this->username() => '该 QQ 暂未绑定大学城!',
                // ]);
                return redirect('/admin/login?error=该QQ暂未绑定大学城!');
            } else {
                $userId = $item->user_id;
                $user = User::find($userId);
                // 到时候记得删
                Cookie::queue('id', $userId, null, null, null, false, true);
                Cookie::queue('role', $user->role_id, null, null, null, false, true);
                // 设置 JWT token
                $customClaims = ['id' => $userId, 'role' => $user->role_id];
                $token = auth('api')->claims($customClaims)->tokenById($userId);
                Cookie::queue('token', $token);
                // 进行登录
                if ($this->guard()->loginUsingId($userId)) return $this->sendLoginResponse($request);
                else {
                    // throw ValidationException::withMessages([
                    //     $this->username() => '未知原因登陆失败!',
                    // ]);
                    return redirect('/admin/login?error=未知原因登陆失败!');
                }
            }
        }
    }

    public function redirectTo()
    {
        return config('voyager.user.redirect', route('voyager.dashboard'));
    }
}
