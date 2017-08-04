<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */

namespace App\Http\Controllers\Wechat\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class usergroupController extends Controller
{
    public function index()
    {
        return view('weixin.group');
    }

    public function edit()
    {
//list{"groups":[{"id":0,"name":"未分组","count":2},{"id":1,"name":"黑名单","count":0},{"id":2,"name":"星标组","count":0},{"id":102,"name":"drc","count":0}]}
        try {
            $wechat = app('wechat');
            $groupService = $wechat->user_group;
            $users = $groupService->lists();
        }catch (\Exception $ex)
        {
            $users = "没有用户组。";
        }
        return view('weixin.group', ['ts' => "用户组列表：" . $users . Carbon::now()->toDateTimeString()]);
    }


    public function show()
    {
        //$group->moveUser($openId, $groupId);

        //$openIds = [$openId1, $openId2, $openId3 ...];
        //$group->moveUsers($openIds, $groupId);

        //$group->delete($groupId);

        //$group->update($groupId, "新的组名");
    }

    public function create()
    {
        //{"group":{"id":104,"name":"drczu2"}}
        $wechat = app('wechat');
        $groupService = $wechat->user_group;
        $users = $groupService->create('drczu2');
        return view('weixin.group', ['ts' => '创建用户组' . $users . Carbon::now()->toDateTimeString()]);
    }
}