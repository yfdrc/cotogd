<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */

namespace App\Http\Controllers\Wechat\Api;

use App\Http\Controllers\Controller;
use App\Model\Wxgroup;
use App\Model\Wxuser;
use Illuminate\Http\Request;

class usergroup2Controller extends Controller
{
    //group原始资料
    public function show($id)
    {
        $wechat = app('wechat');
        $groupService = $wechat->user_group;
        $groupobj = $groupService->lists();

        return view('weixin.group', [ 'ts' => $groupobj]);
    }
    //user原始资料
    public function edit($id)
    {
        $wechat = app('wechat');
        $userService = $wechat->user;
        $userobj = $userService->get('o4zG9wY6IC_d-AGw_iZEeF3OlFhw');
        return view('weixin.group', [ 'ts' => $userobj]);
    }

    public function index()
    {
        $models = Wxuser::orderBy('subtime', 'desc')->paginate(100);
        $fhz = drc_selectidname('wxgroups');
        return view('weixin.group.move', [ 'tasks' => $models, 'gp'=> $fhz]);
    }

    public function create()
    {
        try {
            //{"groups":[{"id":0,"name":"未分组","count":2},
            $wechat = app('wechat');
            $groupService = $wechat->user_group;
            $groupobj = $groupService->lists();
            $groupfhz = '成功执行。';
            foreach ($groupobj as $items){
                foreach ($items as $item) {
                    if (!Wxgroup::find($item['id'])) {
                        Wxgroup::create($item);
                    }
                }
            }
            $groupfhz = '一次性写入微信用户组成功。';
        }catch (\Exception $ex)
        {
            $groupfhz = $ex;
        }
        return view('weixin.group', ['ts' => $groupfhz]);
    }
}