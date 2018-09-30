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
                'id' => 2708895,
                'role_id' => 1,
                'name' => '杨帆',
                'email' => '436495146022@worlduc.com',
                'phone' => '18890336732',
                'QQ' => '1450872874',
                'avatar' => 'http://www.worlduc.com/uploadImage/head/x0/2017118224142HNEeP.jpg',
                'org_id' => '1315555',
                'org_avatar' => 'http://www.worlduc.com/uploadImage/head/x0/201751116324DK3wg.png',
                'password' => '$2y$10$RHR13i.r6Lia5c4wStXUY.M7UAFYC.7b90q0IlM26OMF/5e7G1bE.',
                'cookies' => 'O:27:"GuzzleHttp\\Cookie\\CookieJar":2:{s:36:"' . "\0" . 'GuzzleHttp\\Cookie\\CookieJar' . "\0" . 'cookies";a:4:{i:0;O:27:"GuzzleHttp\\Cookie\\SetCookie":1:{s:33:"' . "\0" . 'GuzzleHttp\\Cookie\\SetCookie' . "\0" . 'data";a:9:{s:4:"Name";s:17:"ASP.NET_SessionId";s:5:"Value";s:24:"wxtttq22ar4v4xtbtaz1cxyw";s:6:"Domain";s:11:"worlduc.com";s:4:"Path";s:1:"/";s:7:"Max-Age";N;s:7:"Expires";N;s:6:"Secure";b:0;s:7:"Discard";b:0;s:8:"HttpOnly";b:1;}}i:1;O:27:"GuzzleHttp\\Cookie\\SetCookie":1:{s:33:"' . "\0" . 'GuzzleHttp\\Cookie\\SetCookie' . "\0" . 'data";a:9:{s:4:"Name";s:22:"WorldUC_ClientIdentity";s:5:"Value";s:32:"9f2c20152ad847848aa3e2d2f88c7661";s:6:"Domain";s:12:".worlduc.com";s:4:"Path";s:1:"/";s:7:"Max-Age";N;s:7:"Expires";N;s:6:"Secure";b:0;s:7:"Discard";b:0;s:8:"HttpOnly";b:1;}}i:2;O:27:"GuzzleHttp\\Cookie\\SetCookie":1:{s:33:"' . "\0" . 'GuzzleHttp\\Cookie\\SetCookie' . "\0" . 'data";a:9:{s:4:"Name";s:12:"SnsUserToken";s:5:"Value";s:113:"token=9NgmT/NMWqbI4QUBnhTyDDR/SWlFy5NLxBVBYqGHfjbUgegdxWM7SngQ4iUMEPGqJKIlYFWwU/k=&headpic=2017118224142HNEeP.jpg";s:6:"Domain";s:12:".worlduc.com";s:4:"Path";s:1:"/";s:7:"Max-Age";N;s:7:"Expires";N;s:6:"Secure";b:0;s:7:"Discard";b:0;s:8:"HttpOnly";b:1;}}i:3;O:27:"GuzzleHttp\\Cookie\\SetCookie":1:{s:33:"' . "\0" . 'GuzzleHttp\\Cookie\\SetCookie' . "\0" . 'data";a:9:{s:4:"Name";s:17:"BIGipServerweb_80";s:5:"Value";s:16:"335745196.0.0000";s:6:"Domain";s:11:"worlduc.com";s:4:"Path";s:1:"/";s:7:"Max-Age";N;s:7:"Expires";N;s:6:"Secure";b:0;s:7:"Discard";b:0;s:8:"HttpOnly";b:0;}}}s:39:"' . "\0" . 'GuzzleHttp\\Cookie\\CookieJar' . "\0" . 'strictMode";b:0;}',
                'remember_token' => 'TJ3CUs7XY4e4sPdpHpWhzyOv6UKTWPPd2c9GLLBXE8hUVOxLRmOdlMTgJAry',
                'settings' => NULL,
                'created_at' => '2018-08-22 11:42:40',
                'updated_at' => '2018-09-30 10:38:41',
            ),
        ));
        
        
    }
}