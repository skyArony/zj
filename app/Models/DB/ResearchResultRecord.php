<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

// 研究成果
class ResearchResultRecord extends Model
{
    protected $table = 'research_result_records';

    protected $fillable = ['id', 'creater_id', 'title', 'title', 'desc', 'detail', 'task_id', 'team_id', 'file'];
}
