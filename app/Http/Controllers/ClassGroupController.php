<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DB\ClassGroup;

class ClassGroupController extends ApiController
{
    // 新建班级
    public function create(Request $request) {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $className = $request->className;
        $classGroup = new ClassGroup;
        $classGroup->className = $className;
        $classGroup->creater_id = $uid;
        if ($classGroup->save()) {
            return self::setResponse($classGroup, 200, 0);
        } else {
            return self::setResponse(null, 400, -4006);
        }
    }

    // 修改班级名
    public function update(Request $request) {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $classId = $request->classId;
        $className = $request->className;
        $classGroup = ClassGroup::where('creater_id', $uid)->where('id', $classId)->first();
        if ($classGroup) {
            $classGroup->className = $className;
            if ($classGroup->save()) {
                return self::setResponse($classGroup, 200, 0);
            } else {
                return self::setResponse(null, 400, -4006);
            }
        } else {
            return self::setResponse(null, 400, -4006);
        }
    }

    // 获取一个班级信息
    public function show(Request $request) {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $classId = $request->classId;
        $classGroup = ClassGroup::where('creater_id', $uid)->where('id', $classId)->first();
        return self::setResponse($classGroup, 200, 0);
    }

    // 获取一个用户创建的所有班级
    public function browse(Request $request) {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $classGroupList = ClassGroup::where('creater_id', $uid)->get();
        return self::setResponse($classGroupList, 200, 0);
    }


    // 删除班级
    public function delete(Request $request) {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $classId = $request->classId;
        if (ClassGroup::where('creater_id', $uid)->where('id', $classId)->first()->delete()) {
            return self::setResponse(null, 200, 0);
        } else {
            return self::setResponse(null, 400, -4006);
        }
    }

    // 给班级添加一个学生
    public function addStudent(Request $request) {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $sid = $request->sid;
        $classId = $request->classId;
        $classGroup = ClassGroup::where('creater_id', $uid)->where('id', $classId)->first();
        $classGroup->belongsToManyUsers()->syncWithoutDetaching($sid);
        return self::setResponse(null, 200, 0);
    }

    // 给班级删除一个学生
    public function removeStudent(Request $request) {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $sid = $request->sid;
        $classId = $request->classId;
        $classGroup = ClassGroup::where('creater_id', $uid)->where('id', $classId)->first();
        $classGroup->belongsToManyUsers()->detach($sid);
            return self::setResponse(null, 200, 0);
    }

    // 获取一个班级的所有成员
    public function getMemberList(Request $request) {
        // TODO validate

        $uid = auth('api')->parseToken()->payload()->get('sub');
        $classId = $request->classId;
        $classGroup = ClassGroup::where('creater_id', $uid)->where('id', $classId)->first();
        $userList = $classGroup->belongsToManyUsers;
        return self::setResponse($userList, 200, 0);
    }

}
