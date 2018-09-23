<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

class ResearchResult extends Model
{
    protected $table = 'research_results';

    public function belongsToTeam()
    {
        return $this->belongsTo('App\Models\DB\Team', 'team_id', 'id');
    }

    public function belongsToTask()
    {
        return $this->belongsTo('App\Models\DB\Task', 'task_id', 'id');
    }
}
