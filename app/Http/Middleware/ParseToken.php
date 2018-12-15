<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware as Middleware;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cookie;

class ParseToken extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = auth('api')->getToken();
        $yyy = explode(".", $token)[1];
        $fiat = json_decode(base64_decode($yyy))->fiat;
        $exp = json_decode(base64_decode($yyy))->exp;
        $now = time();
        // $fiat = auth('api')->parseToken()->payload()->get('fiat');
        // $exp = auth('api')->parseToken()->payload()->get('exp');
        if($now > $exp && $now < $fiat + env("JWT_REFRESH_TTL") * 60) {
            // echo("更新了token");
            // echo($token);
            $token = auth('api')->refresh();
            auth('api')->setToken($token);
            // echo("新 token 是 $token");
            // echo("当前token ");
            // echo auth('api')->getToken();
            $response = $next($request);
            return $response->cookie('token', $token);
        } else return $next($request);
    }

    
}
