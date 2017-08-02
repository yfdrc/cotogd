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

class userController extends Controller
{
    public function index()
    {
        return view('weixin.user');
    }

    public function edit()
    {
        try {
            $wechat = app('wechat');
            $userService = $wechat->user;
            $users = $userService->lists();
        }catch (\Exception $ex)
        {
            $users = "没有用户。";
        }
        return view('weixin.user', ['ts' => '用户列表：' . $users . '  ' . Carbon::now()->toDateTimeString()]);
    }


    public function show()
    {
        $openId = 'o4zG9wY6IC_d-AGw_iZEeF3OlFhw';
        $wechat = app('wechat');
        $userService = $wechat->user;
        $user = $userService->get($openId);
        $userxq = "nickname:$user->nickname  openid: $user->openid  remark: $user->remark";
        return view('weixin.user', ['ts' => '用户详情：' . $userxq . '  ' . Carbon::now()->toDateTimeString()]);
    }

    public function create()
    {

    }
}