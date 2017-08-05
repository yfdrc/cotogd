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

class qrcodeController extends Controller
{
    public function index()
    {
        return view('weixin.qrcode');
    }

    public function edit()
    {
        //{"ticket":"gQFD8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyTjFlVGMxek5lWjExQmdKYzFwMWgAAgRQhIRZAwQA6QcA",
        //"expire_seconds":518400,
        //"url":"http:\/\/weixin.qq.com\/q\/02N1eTc1zNeZ11BgJc1p1h"}
        try {
            $wechat = app('wechat');
            $qrService = $wechat->qrcode;
            $result = $qrService->temporary(2, 6 * 24 * 3600);
            $ticket = $result->ticket;
            $url = $qrService->url($ticket);
            $content = file_get_contents($url); // 得到二进制图片内容
            file_put_contents(storage_path('app/tm'.Carbon::now()->addHour(8)->format('YmdHis').'code.jpg') , $content); // 写入文件
        }catch (\Exception $ex)
        {
            $url = "错误。";
        }
        return view('weixin.qrcode', ['ts' => "创建临时二维码： $result   " . Carbon::now()->toDateTimeString()]);
    }


    public function show()
    {
        try {
            $wechat = app('wechat');
            $qrService = $wechat->qrcode;
            $result = $qrService->url('完美时间');

//            $wechat = app('wechat');
//            $qrService = $wechat->qrcode;
//            $result = $qrService->card($card=null);
//            $ticket = $result->ticket;
//            $url = $qrService->url($ticket);
//            $content = file_get_contents($url); // 得到二进制图片内容
//            file_put_contents(storage_path('app/kq'.Carbon::now()->addHour(8)->format('YmdHis').'code.jpg') , $content); // 写入文件
        }catch (\Exception $ex)
        {
            $result = $ex;
        }
        return view('weixin.qrcode', ['ts' => "获取二维码： $result   " . Carbon::now()->toDateTimeString()]);
    }

    public function create()
    {
         //{"ticket":"gQHo8DwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZ0dXbWQ4ek5lWjExMDAwMDAwN0EAAgSaQn1ZAwQAAAAA",
        //"url":"http:\/\/weixin.qq.com\/q\/02gGWmd8zNeZ110000007A"}
        try {
            $wechat = app('wechat');
            $qrService = $wechat->qrcode;
            $result = $qrService->forever('完美时间');
            $ticket = $result->ticket;
            $url = $qrService->url($ticket);
            $content = file_get_contents($url); // 得到二进制图片内容
            file_put_contents(storage_path('app/yj'.Carbon::now()->addHour(8)->format('YmdHis').'code.jpg') , $content); // 写入文件
        }catch (\Exception $ex)
        {
            $result = "错误。";
        }
        return view('weixin.qrcode', ['ts' => "创建永久二维码： $result   " . Carbon::now()->toDateTimeString()]);
    }
}