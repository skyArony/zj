<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => 'browse_admin',
                'table_name' => NULL,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'browse_bread',
                'table_name' => NULL,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            2 => 
            array (
                'id' => 3,
                'key' => 'browse_database',
                'table_name' => NULL,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            3 => 
            array (
                'id' => 4,
                'key' => 'browse_media',
                'table_name' => NULL,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            4 => 
            array (
                'id' => 5,
                'key' => 'browse_compass',
                'table_name' => NULL,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            5 => 
            array (
                'id' => 6,
                'key' => 'browse_menus',
                'table_name' => 'menus',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            6 => 
            array (
                'id' => 7,
                'key' => 'read_menus',
                'table_name' => 'menus',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            7 => 
            array (
                'id' => 8,
                'key' => 'edit_menus',
                'table_name' => 'menus',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            8 => 
            array (
                'id' => 9,
                'key' => 'add_menus',
                'table_name' => 'menus',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            9 => 
            array (
                'id' => 10,
                'key' => 'delete_menus',
                'table_name' => 'menus',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            10 => 
            array (
                'id' => 11,
                'key' => 'browse_roles',
                'table_name' => 'roles',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            11 => 
            array (
                'id' => 12,
                'key' => 'read_roles',
                'table_name' => 'roles',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            12 => 
            array (
                'id' => 13,
                'key' => 'edit_roles',
                'table_name' => 'roles',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            13 => 
            array (
                'id' => 14,
                'key' => 'add_roles',
                'table_name' => 'roles',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            14 => 
            array (
                'id' => 15,
                'key' => 'delete_roles',
                'table_name' => 'roles',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            15 => 
            array (
                'id' => 16,
                'key' => 'browse_users',
                'table_name' => 'users',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            16 => 
            array (
                'id' => 17,
                'key' => 'read_users',
                'table_name' => 'users',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            17 => 
            array (
                'id' => 18,
                'key' => 'edit_users',
                'table_name' => 'users',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            18 => 
            array (
                'id' => 19,
                'key' => 'add_users',
                'table_name' => 'users',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            19 => 
            array (
                'id' => 20,
                'key' => 'delete_users',
                'table_name' => 'users',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            20 => 
            array (
                'id' => 21,
                'key' => 'browse_settings',
                'table_name' => 'settings',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            21 => 
            array (
                'id' => 22,
                'key' => 'read_settings',
                'table_name' => 'settings',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            22 => 
            array (
                'id' => 23,
                'key' => 'edit_settings',
                'table_name' => 'settings',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            23 => 
            array (
                'id' => 24,
                'key' => 'add_settings',
                'table_name' => 'settings',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            24 => 
            array (
                'id' => 25,
                'key' => 'delete_settings',
                'table_name' => 'settings',
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            25 => 
            array (
                'id' => 26,
                'key' => 'browse_hooks',
                'table_name' => NULL,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            26 => 
            array (
                'id' => 27,
                'key' => 'browse_courses',
                'table_name' => 'courses',
                'created_at' => '2018-06-13 13:17:56',
                'updated_at' => '2018-06-13 13:17:56',
            ),
            27 => 
            array (
                'id' => 28,
                'key' => 'read_courses',
                'table_name' => 'courses',
                'created_at' => '2018-06-13 13:17:56',
                'updated_at' => '2018-06-13 13:17:56',
            ),
            28 => 
            array (
                'id' => 29,
                'key' => 'edit_courses',
                'table_name' => 'courses',
                'created_at' => '2018-06-13 13:17:56',
                'updated_at' => '2018-06-13 13:17:56',
            ),
            29 => 
            array (
                'id' => 30,
                'key' => 'add_courses',
                'table_name' => 'courses',
                'created_at' => '2018-06-13 13:17:56',
                'updated_at' => '2018-06-13 13:17:56',
            ),
            30 => 
            array (
                'id' => 31,
                'key' => 'delete_courses',
                'table_name' => 'courses',
                'created_at' => '2018-06-13 13:17:56',
                'updated_at' => '2018-06-13 13:17:56',
            ),
            31 => 
            array (
                'id' => 37,
                'key' => 'browse_course_trees',
                'table_name' => 'course_trees',
                'created_at' => '2018-06-13 13:30:42',
                'updated_at' => '2018-06-13 13:30:42',
            ),
            32 => 
            array (
                'id' => 38,
                'key' => 'read_course_trees',
                'table_name' => 'course_trees',
                'created_at' => '2018-06-13 13:30:42',
                'updated_at' => '2018-06-13 13:30:42',
            ),
            33 => 
            array (
                'id' => 39,
                'key' => 'edit_course_trees',
                'table_name' => 'course_trees',
                'created_at' => '2018-06-13 13:30:42',
                'updated_at' => '2018-06-13 13:30:42',
            ),
            34 => 
            array (
                'id' => 40,
                'key' => 'add_course_trees',
                'table_name' => 'course_trees',
                'created_at' => '2018-06-13 13:30:42',
                'updated_at' => '2018-06-13 13:30:42',
            ),
            35 => 
            array (
                'id' => 41,
                'key' => 'delete_course_trees',
                'table_name' => 'course_trees',
                'created_at' => '2018-06-13 13:30:42',
                'updated_at' => '2018-06-13 13:30:42',
            ),
            36 => 
            array (
                'id' => 42,
                'key' => 'browse_surveys',
                'table_name' => 'surveys',
                'created_at' => '2018-07-02 16:29:14',
                'updated_at' => '2018-07-02 16:29:14',
            ),
            37 => 
            array (
                'id' => 43,
                'key' => 'read_surveys',
                'table_name' => 'surveys',
                'created_at' => '2018-07-02 16:29:14',
                'updated_at' => '2018-07-02 16:29:14',
            ),
            38 => 
            array (
                'id' => 44,
                'key' => 'edit_surveys',
                'table_name' => 'surveys',
                'created_at' => '2018-07-02 16:29:14',
                'updated_at' => '2018-07-02 16:29:14',
            ),
            39 => 
            array (
                'id' => 45,
                'key' => 'add_surveys',
                'table_name' => 'surveys',
                'created_at' => '2018-07-02 16:29:14',
                'updated_at' => '2018-07-02 16:29:14',
            ),
            40 => 
            array (
                'id' => 46,
                'key' => 'delete_surveys',
                'table_name' => 'surveys',
                'created_at' => '2018-07-02 16:29:14',
                'updated_at' => '2018-07-02 16:29:14',
            ),
            41 => 
            array (
                'id' => 47,
                'key' => 'browse_answer_records',
                'table_name' => 'answer_records',
                'created_at' => '2018-07-26 10:58:15',
                'updated_at' => '2018-07-26 10:58:15',
            ),
            42 => 
            array (
                'id' => 48,
                'key' => 'read_answer_records',
                'table_name' => 'answer_records',
                'created_at' => '2018-07-26 10:58:15',
                'updated_at' => '2018-07-26 10:58:15',
            ),
            43 => 
            array (
                'id' => 49,
                'key' => 'edit_answer_records',
                'table_name' => 'answer_records',
                'created_at' => '2018-07-26 10:58:15',
                'updated_at' => '2018-07-26 10:58:15',
            ),
            44 => 
            array (
                'id' => 50,
                'key' => 'add_answer_records',
                'table_name' => 'answer_records',
                'created_at' => '2018-07-26 10:58:16',
                'updated_at' => '2018-07-26 10:58:16',
            ),
            45 => 
            array (
                'id' => 51,
                'key' => 'delete_answer_records',
                'table_name' => 'answer_records',
                'created_at' => '2018-07-26 10:58:16',
                'updated_at' => '2018-07-26 10:58:16',
            ),
        ));
        
        
    }
}