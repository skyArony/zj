<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
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

        // 时间部分处理
// $regist_end_at = new Carbon($task->ＺＡＡＺAregist_end_at);
//         if ($regist_end_at->lt(Carbon::now())) {

//         }

        
        // var_dump();
        // // var_dump($regist_end_at->isBefore(Carbon::now()));
        // // echo $carbon->diffForHumans(Carbon::now());
        // exit;

        

        $task = $task->toArray();
        array_forget($task, 'belongs_to_many_teams');

        return self::setResponse($task, 200, 0);
    }
}
