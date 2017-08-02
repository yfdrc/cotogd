<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class wechatController extends Controller
{
    public function index()
    {
        $wechat = app('wechat');

        $wechat->server->setMessageHandler(function($message){
//        $message->ToUserName    接收方帐号（该公众号 ID）
//        $message->FromUserName  发送方帐号（OpenID, 代表用户的唯一标识）
//        $message->CreateTime    消息创建时间（时间戳）
//        $message->MsgId         消息 ID（64位整型）
            switch ($message->MsgType) {
                case 'event':
                    switch ($message->Event){
                        case 'subscribe':
                            break;
                        case 'unsubscribe':
                            break;
                        case 'CLICK':
                            return 'CLICK:eventkey=' . $message->EventKey;
                            break;
                        case 'SCAN':
                            return 'SCAN:eventkey=' . $message->EventKey . '  ticket=' . $message->Ticket;
                            break;
                        case 'scancode_waitmsg':
                            return 'scancode_waitmsg:eventkey=' . $message->EventKey . '  ticket=' . $message->Ticket;
                            break;
                        case 'LOCATION':
                            return 'LOCATION:lat='.$message->Latitude.'  lon='.$message->Longitude.'  pre='.$message->Precision;
                            break;
                    }
                    return '收到事件消息：' . $message->Event;
                    break;
                case 'text':
                    $tx = 'new';
                    return '收到文字消息：' . $tx;
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
        });

        return $wechat->server->serve();
    }
}