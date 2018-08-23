<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 3,
                'role_id' => 1,
                'id' => 2708895,
                'name' => '杨帆',
                'email' => '436495146022@worlduc.com',
                'avatar' => 'http://www.worlduc.com/uploadImage/head/x0/2017118224142HNEeP.jpg',
                'org_id' => '1315555',
                'org_avatar' => 'http://www.worlduc.com/uploadImage/head/x0/201751116324DK3wg.png',
                'password' => '$2y$10$i8xFV/i.AkSJbJtyIaRzmeg.RH.JgwnZbCl20hQIi9UsB3R/UjF4q',
                'cookies' => 'O:27:"GuzzleHttp\\Cookie\\CookieJar":2:{s:36:"' . "\0" . 'GuzzleHttp\\Cookie\\CookieJar' . "\0" . 'cookies";a:4:{i:0;O:27:"GuzzleHttp\\Cookie\\SetCookie":1:{s:33:"' . "\0" . 'GuzzleHttp\\Cookie\\SetCookie' . "\0" . 'data";a:9:{s:4:"Name";s:17:"ASP.NET_SessionId";s:5:"Value";s:24:"mwkcxsl0rrfwboixgndvbwf1";s:6:"Domain";s:11:"worlduc.com";s:4:"Path";s:1:"/";s:7:"Max-Age";N;s:7:"Expires";N;s:6:"Secure";b:0;s:7:"Discard";b:0;s:8:"HttpOnly";b:1;}}i:1;O:27:"GuzzleHttp\\Cookie\\SetCookie":1:{s:33:"' . "\0" . 'GuzzleHttp\\Cookie\\SetCookie' . "\0" . 'data";a:9:{s:4:"Name";s:22:"WorldUC_ClientIdentity";s:5:"Value";s:32:"8be37a40f50b4cd2a31e98e4905cba1f";s:6:"Domain";s:12:".worlduc.com";s:4:"Path";s:1:"/";s:7:"Max-Age";N;s:7:"Expires";N;s:6:"Secure";b:0;s:7:"Discard";b:0;s:8:"HttpOnly";b:1;}}i:2;O:27:"GuzzleHttp\\Cookie\\SetCookie":1:{s:33:"' . "\0" . 'GuzzleHttp\\Cookie\\SetCookie' . "\0" . 'data";a:9:{s:4:"Name";s:12:"SnsUserToken";s:5:"Value";s:113:"token=+59qY3H18E49UoKjSc2GhIEyCJAqj/LjwZbFwRSIuNqvqbmGzj+TixAsOTik1jvGLsd38mAlHr4=&headpic=2017118224142HNEeP.jpg";s:6:"Domain";s:12:".worlduc.com";s:4:"Path";s:1:"/";s:7:"Max-Age";N;s:7:"Expires";N;s:6:"Secure";b:0;s:7:"Discard";b:0;s:8:"HttpOnly";b:1;}}i:3;O:27:"GuzzleHttp\\Cookie\\SetCookie":1:{s:33:"' . "\0" . 'GuzzleHttp\\Cookie\\SetCookie' . "\0" . 'data";a:9:{s:4:"Name";s:17:"BIGipServerweb_80";s:5:"Value";s:16:"318967980.0.0000";s:6:"Domain";s:11:"worlduc.com";s:4:"Path";s:1:"/";s:7:"Max-Age";N;s:7:"Expires";N;s:6:"Secure";b:0;s:7:"Discard";b:0;s:8:"HttpOnly";b:0;}}}s:39:"' . "\0" . 'GuzzleHttp\\Cookie\\CookieJar' . "\0" . 'strictMode";b:0;}',
                'remember_token' => 'hNNAdRJLIlZVe1FXtkSqsQnHbj6xneyja0SheRs4ywKvjhp7LkZyrOwQHUaQ',
                'settings' => NULL,
                'created_at' => '2018-06-11 13:52:12',
                'updated_at' => '2018-08-05 09:22:29',
            ),
        ));
        
        
    }
}