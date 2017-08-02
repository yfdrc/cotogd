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

class broadcastController extends Controller
{
    public function index()
    {
//        // 别名方式
//        $broadcast->sendText("大家好！欢迎使用 EasyWeChat。");
//        $broadcast->sendNews($mediaId);
//        $broadcast->sendVoice($mediaId);
//        $broadcast->sendImage($mediaId);
//        //视频：
//        // - 群发给组用户，或者预览群发视频时 $message 为 media_id
//        // - 群发给指定用户时为数组：[$media_Id, $title, $description]
//        $broadcast->sendVideo($message);
//        $broadcast->sendCard($cardId);
        return view('weixin.broadcast');
    }

    public function show()
    {
        $txt = "群发:大家好,欢迎使用。  " . Carbon::now()->toDateTimeString();
        try {
            $wechat = app('wechat');
            $broadcast = $wechat->broadcast;
            $broadcast->sendText($txt);
        }catch (\Exception $ex)
        {
            $txt = "群发文本不成功：$ex";
        }
        return view('weixin.broadcast', ['ts' => '菜单内容：' . $txt . '  ' . Carbon::now()->toDateTimeString()]);
    }

    public function create()
    {
        return view('weixin.broadcast');
    }

    public function edit()
    {
        return view('weixin.broadcast');
    }
}