<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */

namespace App\Http\Controllers\Wechat\Api;

use App\Http\Controllers\Controller;
use App\Model\Wxuser;
use Carbon\Carbon;

class userController extends Controller
{
    public function index()
    {
        return view('weixin.user.index');
    }

    public function create()
    {

    }
    public function store(Request $request)
    {
    }

    public function show()
    {
        $openId = 'o4zG9wY6IC_d-AGw_iZEeF3OlFhw';
        $wechat = app('wechat');
        $userService = $wechat->user;
        $user = $userService->get($openId);
        return view('weixin.user', ['ts' => '微信用户列表：' . $user . '  ' . Carbon::now()->toDateTimeString()]);
    }

    public function edit()
    {
        try {
            $wechat = app('wechat');
            $userService = $wechat->user;
            $userlists = $userService->lists();
            $userobj = json_decode($userlists);
//            $total = $userobj->total;
//            $count = $userobj->count;
//            $nextopenid = $userobj->next_openid;
            $openid = $userobj->data->openid;
            $wxuser = array();
            $userService = $wechat->user;
            foreach ($openid as $item){
                if( !Wxuser::find($item) ){
                    $user = json_decode($userService->get($item));
                    $wxuser['nickname'] = $user->nickname;
                    $wxuser['remark'] = $user->remark;
                    $wxuser['address'] = $user->province . $user->city;
                    $wxuser['groupid'] = $user->groupid;
                    $wxuser['subtime'] = $user->subscribe_time;
                    $wxuser['openid'] = $item;
                    Wxuser::create($wxuser);
                }
            }
        }catch (\Exception $ex)
        {
            $userlists = "错误：$ex";
        }
        return view('weixin.user', ['ts' => '增加微信用户：' . $userlists]);
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}