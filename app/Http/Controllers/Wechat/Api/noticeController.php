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

class noticeController extends Controller
{
    public function index()
    {
        return view('weixin.notice');
    }

    public function edit()
    {
        $txt = '群发模版01成功。';
        try {
            $userId = 'o4zG9wY6IC_d-AGw_iZEeF3OlFhw';
            $templateId = '4UjD5MsPhjOaWllW8EeJpCMduDSci2GpHHiz9xD5Py0';
            $url = 'http://112.74.161.57/cotogd';
            $data = array(
                "first"  => array("value" => "01恭喜你购买成功！   时间：" . Carbon::now()->toTimeString(), "color" => '#555555'),
                "name"   => array("value" => "巧克力", "color" => "#336699"),
                "price"  => array("value" => "20.00元","color" => "#FF0000"),
                "num"  =>   array("value" => "2","color" => "#888888"),
                "all"  =>   array("value" => "40.00元","color" => "#5599FF"),
                "remark" => array("value" => "欢迎再次购买！", "color" => '#555555'),
            );
            $wechat = app('wechat');
            $notice = $wechat->notice;
            $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        }catch (\Exception $ex)
        {
            $txt = "群发模版01不成功：$ex";
        }
        return view('weixin.notice', ['ts' => '删除菜单：' . $txt . '  ' . Carbon::now()->toDateTimeString()]);
    }


    public function show()
    {
        $txt = '群发模版02成功。';
        try {
            $userId = 'o4zG9wY6IC_d-AGw_iZEeF3OlFhw';
            $templateId = 'Z6onwIKzYdiDIT1wYx4dWTBIMlzBIxvgWEmGY_dcBew';
            $url = 'http://112.74.161.57/cotogd';
            $data = array(
                "first"  => array("value" => "02恭喜你购买成功！   时间：" . Carbon::now()->toTimeString(), "color" => '#555555'),
                "name"   => array("value" => "巧克力", "color" => "#336699"),
                "price"  => array("value" => "20.00元","color" => "#FF0000"),
                "num"  =>   array("value" => "2","color" => "#888888"),
                "all"  =>   array("value" => "40.00元","color" => "#5599FF"),
                "remark" => array("value" => "欢迎再次购买！", "color" => '#555555'),
            );
            $wechat = app('wechat');
            $notice = $wechat->notice;
            $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        }catch (\Exception $ex)
        {
            $txt = "群发模版02不成功：$ex";
        }
        return view('weixin.notice', ['ts' => '删除菜单：' . $txt . '  ' . Carbon::now()->toDateTimeString()]);
    }

    public function create()
    {
        $txt = '群发模版03成功。';
        try {
            $userId = 'o4zG9wY6IC_d-AGw_iZEeF3OlFhw';
            $templateId = 'pxfmXnU-eTwLVR-qGUUoNsSk-fGuAXnc1pCmYQwEtUY';
            $url = 'http://112.74.161.57/cotogd';
            $data = array(
                "first"  => array("value" => "03恭喜你购买成功！   时间：" . Carbon::now()->toTimeString(), "color" => '#555555'),
                "name"   => array("value" => "巧克力", "color" => "#336699"),
                "price"  => array("value" => "20.00元","color" => "#FF0000"),
                "num"  =>   array("value" => "2","color" => "#888888"),
                "all"  =>   array("value" => "40.00元","color" => "#5599FF"),
                "remark" => array("value" => "欢迎再次购买！", "color" => '#555555'),
            );
            $wechat = app('wechat');
            $notice = $wechat->notice;
            $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        }catch (\Exception $ex)
        {
            $txt = "群发模版03不成功：$ex";
        }
        return view('weixin.notice', ['ts' => '删除菜单：' . $txt . '  ' . Carbon::now()->toDateTimeString()]);
    }
}