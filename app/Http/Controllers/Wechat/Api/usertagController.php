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

class usertagController extends Controller
{
    public function index()
    {
        return view('weixin.tag');
    }

    public function edit()
    {
        try {
            $wechat = app('wechat');
            $userService = $wechat->user_tag;
            $users = $userService->lists();
        }catch (\Exception $ex)
        {
            $users = "没有用户标签。";
        }
        return view('weixin.tag', ['ts' => '用户标签列表：' . $users . '  ' . Carbon::now()->toDateTimeString()]);
    }


    public function show()
    {
        $wechat = app('wechat');
        $userService = $wechat->user_tag;
        $tagarr = $userService->lists();
        $userService->delete($tagarr['tags'][1]['id']);
        return view('weixin.tag', ['ts' => '删除用户标签。' . Carbon::now()->toDateTimeString()]);
    }

    public function create()
    {
        $wechat = app('wechat');
        $userService = $wechat->user_tag;
        $userService->create("drc");
        return view('weixin.tag', ['ts' => '创建用户标签：drc。' . Carbon::now()->toDateTimeString()]);
    }
}