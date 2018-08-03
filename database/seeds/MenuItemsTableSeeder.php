<?php

use Illuminate\Database\Seeder;

class MenuItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menu_items')->delete();
        
        \DB::table('menu_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'menu_id' => 1,
                'title' => '控制面板',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-boat',
                'color' => NULL,
                'parent_id' => NULL,
                'order' => 1,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-08-03 06:52:43',
                'route' => 'voyager.dashboard',
                'parameters' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'menu_id' => 1,
                'title' => '媒体',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-images',
                'color' => NULL,
                'parent_id' => 5,
                'order' => 3,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-08-03 06:53:11',
                'route' => 'voyager.media.index',
                'parameters' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'menu_id' => 1,
                'title' => '用户',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-person',
                'color' => NULL,
                'parent_id' => 20,
                'order' => 1,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-08-03 06:52:26',
                'route' => 'voyager.users.index',
                'parameters' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'menu_id' => 1,
                'title' => '角色',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-lock',
                'color' => NULL,
                'parent_id' => 20,
                'order' => 2,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-08-03 06:52:32',
                'route' => 'voyager.roles.index',
                'parameters' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'menu_id' => 1,
                'title' => '工具',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-tools',
                'color' => NULL,
                'parent_id' => NULL,
                'order' => 6,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-08-03 06:52:23',
                'route' => NULL,
                'parameters' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'menu_id' => 1,
                'title' => '菜单管理',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-list',
                'color' => NULL,
                'parent_id' => 20,
                'order' => 5,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-08-03 06:53:08',
                'route' => 'voyager.menus.index',
                'parameters' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'menu_id' => 1,
                'title' => '数据库',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-data',
                'color' => NULL,
                'parent_id' => 20,
                'order' => 3,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-08-03 06:52:34',
                'route' => 'voyager.database.index',
                'parameters' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'menu_id' => 1,
                'title' => '指南针',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-compass',
                'color' => NULL,
                'parent_id' => 5,
                'order' => 1,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-08-03 06:53:11',
                'route' => 'voyager.compass.index',
                'parameters' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'menu_id' => 1,
                'title' => 'BREAD',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-bread',
                'color' => NULL,
                'parent_id' => 20,
                'order' => 4,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-08-03 06:52:37',
                'route' => 'voyager.bread.index',
                'parameters' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'menu_id' => 1,
                'title' => '设置',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-settings',
                'color' => NULL,
                'parent_id' => 20,
                'order' => 6,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-08-03 06:53:11',
                'route' => 'voyager.settings.index',
                'parameters' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'menu_id' => 1,
                'title' => 'Hooks',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-hook',
                'color' => NULL,
                'parent_id' => 5,
                'order' => 2,
                'created_at' => '2018-06-11 13:51:59',
                'updated_at' => '2018-08-03 06:53:11',
                'route' => 'voyager.hooks',
                'parameters' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'menu_id' => 1,
                'title' => '课程',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-book',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 2,
                'created_at' => '2018-06-13 13:17:56',
                'updated_at' => '2018-08-03 06:52:43',
                'route' => 'voyager.courses.index',
                'parameters' => 'null',
            ),
            12 => 
            array (
                'id' => 17,
                'menu_id' => 1,
                'title' => '问卷',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-file-text',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 3,
                'created_at' => '2018-07-02 16:29:14',
                'updated_at' => '2018-08-03 06:52:41',
                'route' => 'voyager.surveys.index',
                'parameters' => 'null',
            ),
            13 => 
            array (
                'id' => 18,
                'menu_id' => 1,
                'title' => '问卷记录',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-pen',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 4,
                'created_at' => '2018-07-26 10:58:16',
                'updated_at' => '2018-08-03 06:52:41',
                'route' => 'voyager.answer-records.index',
                'parameters' => 'null',
            ),
            14 => 
            array (
                'id' => 20,
                'menu_id' => 1,
                'title' => '后台编辑',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-activity',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 5,
                'created_at' => '2018-08-03 06:52:13',
                'updated_at' => '2018-08-03 06:52:41',
                'route' => NULL,
                'parameters' => '',
            ),
        ));
        
        
    }
}