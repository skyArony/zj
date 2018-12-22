<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\Request as RequestModel;


class RequestController extends ApiController
{
    // 查看指定申请
    public function getRequest(Request $request) {
        // TODO validate

        if ($req = RequestModel::find($request->id, ['file', 'detail', 'title'])) {
            return self::setResponse($req, 200, 0);
        } else 
            return self::setResponse(null, 404, -4005);
    }
}
