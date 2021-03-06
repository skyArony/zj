<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\Request as RequestModel;


class RequestController extends ApiController
{
    // 查看指定申请
    public function getRequest(Request $request) {
        // TODO validate

        if ($req = RequestModel::find($request->id)) {
            $task = $req->belongsToTask;
            $res = ['taskOwner' => $task->creater_id , 'file' => $req->file, 'detail' => $req->detail, 'title' => $req->title, 'status' => $req->status, 'comment' => $req->comment];
            return self::setResponse($res, 200, 0);
        } else 
            return self::setResponse(null, 404, -4005);
    }

    // 审查申请书
    public function reviewRequest(Request $request) {
        // TODO validate

        $req = RequestModel::find($request->id);
        $req->status = $request->status;
        $req->comment = $request->comment;
        $req->save();
        return self::setResponse($req, 200, 0);
    }
}
