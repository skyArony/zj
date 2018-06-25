<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    for ($i = 0; $i < 12; $i++) {
        $url = "http://www.seuu.me/portal.php?x=51914";
        $ip = "100.100.".rand(1, 255).".".rand(1, 255);
        $headers = array("X-FORWARDED-FOR:$ip");
     
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0");
        $src = curl_exec($curl);
        curl_close($curl);
        echo "yes";
    }
    // return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    // 覆盖了原先的登陆，添加了自定义的本身认证
    Route::post('login', 'LoginController@postLogin');
});
