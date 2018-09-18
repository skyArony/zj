<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\Task;
use App\User;

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

    public function getTaskDetail(Request $request) {
        // TODO validate

        $taskId = $request->taskId;

        $task = Task::find($taskId);
        $creater = User::find($task->creater_id);
        $registTeams = $task->belongsToManyTeams->count();

        // 数据处理
        $task->creater_avatar = $creater->avatar;
        $task->creater_name = $creater->name;
        $task->registTeams = $registTeams;
        $task->file = json_decode($task->file);
        $task->signTeams = $task->belongsToManyTeams->pluck('id')->toArray();

        // 时间部分处理
        $registRemain = strtotime($task->regist_end_at) - time();
        if ($registRemain < 0) $task->regist_end_at = "已过期";
        else {
            $days = floor($registRemain / 86400);
            $hours = floor(($registRemain - $days * 86400) / 3600);
            $mins = floor(($registRemain - $days * 86400 - $hours * 3600) / 60);
            if (!$days && !$hours) $task->regist_end_at = $hours . "时" . $mins . "分"; 
            else $task->regist_end_at = $days . "天" . $hours . "时"; 
        }

        $submitRemain = strtotime($task->submit_end_at) - time();
        if ($submitRemain < 0) $task->submit_end_at = "已过期";
        else {
            $days = floor($submitRemain / 86400);
            $hours = floor(($submitRemain - $days * 86400) / 3600);
            $mins = floor(($submitRemain - $days * 86400 - $hours * 3600) / 60);
            if (!$days && !$hours) $task->submit_end_at = $hours . "时" . $mins . "分"; 
            else $task->submit_end_at = $days . "天" . $hours . "时"; 
        }

        $task = $task->toArray();
        array_forget($task, 'belongs_to_many_teams');

        return self::setResponse($task, 200, 0);
    }

    public function getMoreTasks(Request $request) {
        // TODO validate

        $userId = $request->userId;

        $tasks = Task::where('creater_id', $userId)->get(['id', 'title']);
        return self::setResponse($tasks, 200, 0);
    }
}
