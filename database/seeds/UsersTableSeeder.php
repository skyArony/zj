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
                'sid' => NULL,
                'phone' => NULL,
                'QQ' => '1450872874',
                'avatar' => 'http://www.worlduc.com/uploadImage/head/x0/201943114325gqqoW.jpg',
                'org_id' => '1315555',
                'org_avatar' => 'http://www.worlduc.com/uploadImage/head/x0/201751116324DK3wg.png',
                'password' => '$2y$10$/HHzits95tmqOkuNgpFBdud39M14GPNB9e459jvVMF8oR53pvyrkK',
                'cookies' => 'O:27:"GuzzleHttp\\Cookie\\CookieJar":2:{s:36:"' . "\0" . 'GuzzleHttp\\Cookie\\CookieJar' . "\0" . 'cookies";a:4:{i:0;O:27:"GuzzleHttp\\Cookie\\SetCookie":1:{s:33:"' . "\0" . 'GuzzleHttp\\Cookie\\SetCookie' . "\0" . 'data";a:9:{s:4:"Name";s:17:"ASP.NET_SessionId";s:5:"Value";s:24:"j4l2i4ghm3lv50ncl5helmc3";s:6:"Domain";s:11:"worlduc.com";s:4:"Path";s:1:"/";s:7:"Max-Age";N;s:7:"Expires";N;s:6:"Secure";b:0;s:7:"Discard";b:0;s:8:"HttpOnly";b:1;}}i:1;O:27:"GuzzleHttp\\Cookie\\SetCookie":1:{s:33:"' . "\0" . 'GuzzleHttp\\Cookie\\SetCookie' . "\0" . 'data";a:9:{s:4:"Name";s:22:"WorldUC_ClientIdentity";s:5:"Value";s:32:"fd5f123849624361afe71ee1e7e4a856";s:6:"Domain";s:12:".worlduc.com";s:4:"Path";s:1:"/";s:7:"Max-Age";N;s:7:"Expires";N;s:6:"Secure";b:0;s:7:"Discard";b:0;s:8:"HttpOnly";b:1;}}i:2;O:27:"GuzzleHttp\\Cookie\\SetCookie":1:{s:33:"' . "\0" . 'GuzzleHttp\\Cookie\\SetCookie' . "\0" . 'data";a:9:{s:4:"Name";s:12:"SnsUserToken";s:5:"Value";s:112:"token=tXBB3eYt5qoQl2QkTss5+D7ji7Qc32dNBw7JbyAaNtkQ15M7XWGouzZwbjSfI6V5xq50n9lJ8/o=&headpic=201943114325gqqoW.jpg";s:6:"Domain";s:12:".worlduc.com";s:4:"Path";s:1:"/";s:7:"Max-Age";N;s:7:"Expires";N;s:6:"Secure";b:0;s:7:"Discard";b:0;s:8:"HttpOnly";b:1;}}i:3;O:27:"GuzzleHttp\\Cookie\\SetCookie":1:{s:33:"' . "\0" . 'GuzzleHttp\\Cookie\\SetCookie' . "\0" . 'data";a:9:{s:4:"Name";s:17:"BIGipServerweb_80";s:5:"Value";s:16:"268636332.0.0000";s:6:"Domain";s:11:"worlduc.com";s:4:"Path";s:1:"/";s:7:"Max-Age";N;s:7:"Expires";N;s:6:"Secure";b:0;s:7:"Discard";b:0;s:8:"HttpOnly";b:0;}}}s:39:"' . "\0" . 'GuzzleHttp\\Cookie\\CookieJar' . "\0" . 'strictMode";b:0;}',
                'login_key' => 'cf67e4188eb2b47236e7a21ed5481a1c',
                'remember_token' => '37QU5fS8vg14aJ0aGGLDyJf9hUFfQBTjM3huYMzRAMjDnGbDMyCMSZEtF7hO',
                'settings' => NULL,
                'created_at' => '2018-09-30 16:03:45',
                'updated_at' => '2019-04-06 14:46:28',
            ),
        ));
        
        
    }
}