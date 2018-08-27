<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\Task;

class TaskController extends ApiController
{
    // 获取系统中所有的 task
    public function getAllTask() {
        $tasks = Task::all();
        return self::setResponse($tasks, 200, 0);
    }
}
