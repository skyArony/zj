<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\Task;

class TaskController extends ApiController
{
    // 获取系统中所有的 task及其创建者部分信息
    public function getAllTask() {
        $tasks = Task::with('belongsToUser')->get(['id', 'title', 'desc', 'created_at', 'creater_id']);
        $tasks = $tasks->map(function($item, $key) {
            $creater = $item->belongsToUser;
            $item['creater'] = ["name" => $creater->name, "avatar" => $creater->avatar];
            return $item;
        })->toArray();
        foreach ($tasks as $key => $value) {
            array_forget($tasks[$key], 'belongs_to_user');
        }
        return self::setResponse($tasks, 200, 0);
    }
}
