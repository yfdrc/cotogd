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
use Illuminate\Http\Request;

class usergroup2Controller extends Controller
{
    public function create()
    {
        try {
            //{"groups":[{"id":0,"name":"未分组","count":2},
            $wechat = app('wechat');
            $groupService = $wechat->user_group;
            $groupobj = $groupService->lists();
            $groupfhz = '';
            foreach ($groupobj as $item){
                if( !Wxgroup::find($item->id) ){
                    $wxgroup['id'] = $item->id;
                    $wxgroup['name'] = $item->name;
                    $wxgroup['count'] = $item->count;
                    $groupfhz += Wxgroup::create($wxgroup);
                }
            }
        }catch (\Exception $ex)
        {
            $groupfhz += $ex;
        }
        return redirect(url('wechatapigroup'))->withErrors(['一次性写入微信用户组：' . $groupfhz]);
    }

    public function edit($id)
    {
        $models = Wxgroup::paginate(100);
        $fhz = drc_selectidname('wxgroups');
        return view('weixin.group.move', [ 'tasks' => $models,'gp'=> $fhz]);
    }

    public function update(Request $request, $id)
    {
        //$item:$openIds = [$openId1, $openId2, $openId3 ...];$openId;
        $input = $request->all();
        $groupId = $input['input'];
        $tomove = $input['tomove'];
        $wechat = app('wechat');
        $groupService = $wechat->user_group;
        if(is_array($tomove)){
            $groupfhz = $groupService->moveUsers($tomove, $groupId);
        }else{
            $groupfhz = $groupService->moveUser($tomove, $groupId);
        }
        return redirect(url('wechatapigroup'))->withErrors(['移入新用户组：' . $groupfhz]);
    }
}