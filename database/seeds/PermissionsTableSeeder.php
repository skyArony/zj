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
                'id' => 57,
                'key' => 'browse_tasks',
                'table_name' => 'tasks',
                'created_at' => '2018-08-21 03:51:06',
                'updated_at' => '2018-08-21 03:51:06',
            ),
            37 => 
            array (
                'id' => 58,
                'key' => 'read_tasks',
                'table_name' => 'tasks',
                'created_at' => '2018-08-21 03:51:06',
                'updated_at' => '2018-08-21 03:51:06',
            ),
            38 => 
            array (
                'id' => 59,
                'key' => 'edit_tasks',
                'table_name' => 'tasks',
                'created_at' => '2018-08-21 03:51:06',
                'updated_at' => '2018-08-21 03:51:06',
            ),
            39 => 
            array (
                'id' => 60,
                'key' => 'add_tasks',
                'table_name' => 'tasks',
                'created_at' => '2018-08-21 03:51:06',
                'updated_at' => '2018-08-21 03:51:06',
            ),
            40 => 
            array (
                'id' => 61,
                'key' => 'delete_tasks',
                'table_name' => 'tasks',
                'created_at' => '2018-08-21 03:51:06',
                'updated_at' => '2018-08-21 03:51:06',
            ),
            41 => 
            array (
                'id' => 62,
                'key' => 'browse_teams',
                'table_name' => 'teams',
                'created_at' => '2018-08-21 08:26:14',
                'updated_at' => '2018-08-21 08:26:14',
            ),
            42 => 
            array (
                'id' => 63,
                'key' => 'read_teams',
                'table_name' => 'teams',
                'created_at' => '2018-08-21 08:26:14',
                'updated_at' => '2018-08-21 08:26:14',
            ),
            43 => 
            array (
                'id' => 64,
                'key' => 'edit_teams',
                'table_name' => 'teams',
                'created_at' => '2018-08-21 08:26:14',
                'updated_at' => '2018-08-21 08:26:14',
            ),
            44 => 
            array (
                'id' => 65,
                'key' => 'add_teams',
                'table_name' => 'teams',
                'created_at' => '2018-08-21 08:26:14',
                'updated_at' => '2018-08-21 08:26:14',
            ),
            45 => 
            array (
                'id' => 66,
                'key' => 'delete_teams',
                'table_name' => 'teams',
                'created_at' => '2018-08-21 08:26:14',
                'updated_at' => '2018-08-21 08:26:14',
            ),
            46 => 
            array (
                'id' => 67,
                'key' => 'browse_research_results',
                'table_name' => 'research_results',
                'created_at' => '2018-08-21 08:38:07',
                'updated_at' => '2018-08-21 08:38:07',
            ),
            47 => 
            array (
                'id' => 68,
                'key' => 'read_research_results',
                'table_name' => 'research_results',
                'created_at' => '2018-08-21 08:38:07',
                'updated_at' => '2018-08-21 08:38:07',
            ),
            48 => 
            array (
                'id' => 69,
                'key' => 'edit_research_results',
                'table_name' => 'research_results',
                'created_at' => '2018-08-21 08:38:07',
                'updated_at' => '2018-08-21 08:38:07',
            ),
            49 => 
            array (
                'id' => 70,
                'key' => 'add_research_results',
                'table_name' => 'research_results',
                'created_at' => '2018-08-21 08:38:07',
                'updated_at' => '2018-08-21 08:38:07',
            ),
            50 => 
            array (
                'id' => 71,
                'key' => 'delete_research_results',
                'table_name' => 'research_results',
                'created_at' => '2018-08-21 08:38:07',
                'updated_at' => '2018-08-21 08:38:07',
            ),
            51 => 
            array (
                'id' => 72,
                'key' => 'browse_requests',
                'table_name' => 'requests',
                'created_at' => '2018-12-16 22:01:41',
                'updated_at' => '2018-12-16 22:01:41',
            ),
            52 => 
            array (
                'id' => 73,
                'key' => 'read_requests',
                'table_name' => 'requests',
                'created_at' => '2018-12-16 22:01:41',
                'updated_at' => '2018-12-16 22:01:41',
            ),
            53 => 
            array (
                'id' => 74,
                'key' => 'edit_requests',
                'table_name' => 'requests',
                'created_at' => '2018-12-16 22:01:41',
                'updated_at' => '2018-12-16 22:01:41',
            ),
            54 => 
            array (
                'id' => 75,
                'key' => 'add_requests',
                'table_name' => 'requests',
                'created_at' => '2018-12-16 22:01:41',
                'updated_at' => '2018-12-16 22:01:41',
            ),
            55 => 
            array (
                'id' => 76,
                'key' => 'delete_requests',
                'table_name' => 'requests',
                'created_at' => '2018-12-16 22:01:41',
                'updated_at' => '2018-12-16 22:01:41',
            ),
            56 => 
            array (
                'id' => 77,
                'key' => 'browse_questions',
                'table_name' => 'questions',
                'created_at' => '2019-01-01 16:48:51',
                'updated_at' => '2019-01-01 16:48:51',
            ),
            57 => 
            array (
                'id' => 78,
                'key' => 'read_questions',
                'table_name' => 'questions',
                'created_at' => '2019-01-01 16:48:51',
                'updated_at' => '2019-01-01 16:48:51',
            ),
            58 => 
            array (
                'id' => 79,
                'key' => 'edit_questions',
                'table_name' => 'questions',
                'created_at' => '2019-01-01 16:48:51',
                'updated_at' => '2019-01-01 16:48:51',
            ),
            59 => 
            array (
                'id' => 80,
                'key' => 'add_questions',
                'table_name' => 'questions',
                'created_at' => '2019-01-01 16:48:51',
                'updated_at' => '2019-01-01 16:48:51',
            ),
            60 => 
            array (
                'id' => 81,
                'key' => 'delete_questions',
                'table_name' => 'questions',
                'created_at' => '2019-01-01 16:48:51',
                'updated_at' => '2019-01-01 16:48:51',
            ),
            61 => 
            array (
                'id' => 82,
                'key' => 'browse_class',
                'table_name' => 'class',
                'created_at' => '2019-02-26 19:03:29',
                'updated_at' => '2019-02-26 19:03:29',
            ),
            62 => 
            array (
                'id' => 83,
                'key' => 'read_class',
                'table_name' => 'class',
                'created_at' => '2019-02-26 19:03:29',
                'updated_at' => '2019-02-26 19:03:29',
            ),
            63 => 
            array (
                'id' => 84,
                'key' => 'edit_class',
                'table_name' => 'class',
                'created_at' => '2019-02-26 19:03:29',
                'updated_at' => '2019-02-26 19:03:29',
            ),
            64 => 
            array (
                'id' => 85,
                'key' => 'add_class',
                'table_name' => 'class',
                'created_at' => '2019-02-26 19:03:29',
                'updated_at' => '2019-02-26 19:03:29',
            ),
            65 => 
            array (
                'id' => 86,
                'key' => 'delete_class',
                'table_name' => 'class',
                'created_at' => '2019-02-26 19:03:29',
                'updated_at' => '2019-02-26 19:03:29',
            ),
        ));
        
        
    }
}