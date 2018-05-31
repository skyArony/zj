<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

class Login extends Model
{
    private $worlduc_login = 'http://worlduc.com/index.aspx';


    public static function login(){
        // 构建goutte实例
        $goutteClient = new Client();
        // 构建guzzle实例
        $guzzleClient = new GuzzleClient(array(
            'timeout' => 15,
        ));
        // 把guzzle实例属性赋予goutte
        $goutteClient->setClient($guzzleClient);

        // 返回crawler实例
        $crawler = $goutteClient->request('POST', self::$worlduc_login, [
            'form_params' => [
                'op' => 'Login',
                'email' => '436495146022@worlduc.com',
                'pass' => 'worlduc147'
            ]
        ]);

        var_dump($crawler);




//        $crawler = $goutteClient->click($crawler->selectLink('[登录]')->link());
//        $form = $crawler->selectButton('Sign in')->form();
//        $crawler = $goutteClient->submit($form, array('login' => 'fabpot', 'password' => 'xxxxxx'));
//        $crawler->filter('.flash-error')->each(function ($node) {
//            print $node->text()."\n";
//        });

    }

}
