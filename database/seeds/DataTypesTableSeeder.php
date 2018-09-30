<?php

use Illuminate\Database\Seeder;

class DataTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('data_types')->delete();
        
        \DB::table('data_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'users',
                'slug' => 'users',
                'display_name_singular' => '用户',
                'display_name_plural' => '用户',
                'icon' => 'voyager-person',
                'model_name' => 'TCG\\Voyager\\Models\\User',
                'policy_name' => 'TCG\\Voyager\\Policies\\UserPolicy',
                'controller' => '',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'menus',
                'slug' => 'menus',
                'display_name_singular' => '菜单',
                'display_name_plural' => '菜单',
                'icon' => 'voyager-list',
                'model_name' => 'TCG\\Voyager\\Models\\Menu',
                'policy_name' => NULL,
                'controller' => '',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'roles',
                'slug' => 'roles',
                'display_name_singular' => '角色',
                'display_name_plural' => '角色',
                'icon' => 'voyager-lock',
                'model_name' => 'TCG\\Voyager\\Models\\Role',
                'policy_name' => NULL,
                'controller' => '',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-06-11 13:51:59',
            ),
            3 => 
            array (
                'id' => 5,
                'name' => 'courses',
                'slug' => 'courses',
                'display_name_singular' => '课程',
                'display_name_plural' => '课程',
                'icon' => 'voyager-book',
                'model_name' => 'App\\Models\\DB\\Course',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null}',
                'created_at' => '2018-06-13 13:17:56',
                'updated_at' => '2018-09-30 01:02:55',
            ),
            4 => 
            array (
                'id' => 7,
                'name' => 'course_trees',
                'slug' => 'course-trees',
                'display_name_singular' => '课程目录',
                'display_name_plural' => '课程目录',
                'icon' => 'voyager-documentation',
                'model_name' => 'App\\Models\\DB\\CourseTree',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null}',
                'created_at' => '2018-06-13 13:30:42',
                'updated_at' => '2018-08-03 06:46:50',
            ),
            5 => 
            array (
                'id' => 8,
                'name' => 'surveys',
                'slug' => 'surveys',
                'display_name_singular' => '问卷',
                'display_name_plural' => '问卷',
                'icon' => 'voyager-file-text',
                'model_name' => 'App\\Models\\DB\\Survey',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null}',
                'created_at' => '2018-07-02 16:29:14',
                'updated_at' => '2018-08-03 07:12:37',
            ),
            6 => 
            array (
                'id' => 10,
                'name' => 'answer_records',
                'slug' => 'answer-records',
                'display_name_singular' => '问卷记录',
                'display_name_plural' => '问卷记录',
                'icon' => 'voyager-pen',
                'model_name' => 'App\\Models\\DB\\AnswerRecord',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null}',
                'created_at' => '2018-07-26 10:58:15',
                'updated_at' => '2018-07-26 10:58:45',
            ),
            7 => 
            array (
                'id' => 14,
                'name' => 'tasks',
                'slug' => 'tasks',
                'display_name_singular' => '课题',
                'display_name_plural' => '课题',
                'icon' => 'voyager-news',
                'model_name' => 'App\\Models\\DB\\Task',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null}',
                'created_at' => '2018-08-21 03:51:06',
                'updated_at' => '2018-09-18 16:14:16',
            ),
            8 => 
            array (
                'id' => 15,
                'name' => 'teams',
                'slug' => 'teams',
                'display_name_singular' => '团队',
                'display_name_plural' => '团队',
                'icon' => 'voyager-group',
                'model_name' => 'App\\Models\\DB\\Team',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null}',
                'created_at' => '2018-08-21 08:26:14',
                'updated_at' => '2018-09-18 16:15:50',
            ),
            9 => 
            array (
                'id' => 17,
                'name' => 'research_results',
                'slug' => 'research-results',
                'display_name_singular' => '科研成果',
                'display_name_plural' => '科研成果',
                'icon' => 'voyager-receipt',
                'model_name' => 'App\\Models\\DB\\ResearchResult',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null}',
                'created_at' => '2018-08-21 08:38:07',
                'updated_at' => '2018-09-18 16:17:41',
            ),
        ));
        
        
    }
}