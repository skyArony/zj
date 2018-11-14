<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dingo\Api\Http\Response;

class ApiController extends Controller
{
    // 构造响应
    public static function setResponse($data, $status, $errcode)
    {
        $body = array(
            'errcode' => $errcode,
            'status' => $status,
            'errmsg' => self::__getErrMsg($errcode),
            'data' => $data
        );
        $response = new Response($body);
        return $response->setStatusCode($status);
    }

    // errcode 对应的 errmsg
    protected static function __getErrMsg($errcode)
    {
        $msgForCode = array(
            // 通用部分
            0 => 'Success', // 请求成功
            -4001 => '你可能刚刚更新了大学城平台的密码，请用新密码登录！',
            -4002 => '用户名或密码错误！',
            -4003 => '对不起，你连续登录失败次数超过限制，请稍候重试！',
            -4004 => '缺失必要的参数',
            -4005 => '未查询到有效数据',
            -4006 => '数据操作失败',
            -4007 => '未登录',
            -4008 => '大学城系统暂时不可用',
            -4009 => '没有操作权限!',        //  非法篡改请求数据
            -4010 => '队长不能添加或删除!',
            -4011 => '参数不能为空',
            -4012 => '参数错误!',
            -4013 => '已过期, 无法操作!',
            -4014 => '登陆 key 校验不通过'
        );
        return $msgForCode[$errcode];
    }
}
