<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'root',
                'display_name' => '超级管理员',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-07-28 15:52:07',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'admin',
                'display_name' => '管理员',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-07-28 15:52:22',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'teacher',
                'display_name' => '教师',
                'created_at' => '2018-07-28 15:52:39',
                'updated_at' => '2018-07-28 15:52:39',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'student',
                'display_name' => '学生',
                'created_at' => '2018-07-28 15:52:55',
                'updated_at' => '2018-07-28 15:52:55',
            ),
        ));
        
        
    }
}