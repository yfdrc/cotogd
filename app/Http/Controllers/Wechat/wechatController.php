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
use EasyWeChat\Message\Location;
use EasyWeChat\Support\Log;

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
                            //{"ToUserName":"gh_f21725d36b7c","FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw","CreateTime":"1501775822","MsgType":"event","Event":"subscribe","EventKey":null}
                            break;
                        case 'unsubscribe':
                            //{"ToUserName":"gh_f21725d36b7c","FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw","CreateTime":"1501775503","MsgType":"event","Event":"unsubscribe","EventKey":null}
                            break;
                        case 'CLICK':
                            //{"ToUserName":"gh_f21725d36b7c","FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw","CreateTime":"1501776202","MsgType":"event","Event":"CLICK","EventKey":"V1002_TJ"}
                            break;
                        case 'VIEW':
                            //{"ToUserName":"gh_f21725d36b7c","FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw","CreateTime":"1501776210","MsgType":"event","Event":"VIEW","EventKey":"http://112.74.161.57/cotogd/example","MenuId":"424658939"}
                            break;
                        case 'SCAN':
                            //{"ToUserName":"gh_f21725d36b7c","FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw","CreateTime":"1501779805","MsgType":"event","Event":"SCAN","EventKey":"drc","Ticket":"gQHo8DwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZ0dXbWQ4ek5lWjExMDAwMDAwN0EAAgSaQn1ZAwQAAAAA"}
                            break;
                        case 'scancode_waitmsg':
                            //{"ToUserName":"gh_f21725d36b7c","FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw","CreateTime":"1501778410","MsgType":"event","Event":"scancode_waitmsg","EventKey":"rselfmenu_0_0","ScanCodeInfo":{"ScanType":"qrcode","ScanResult":"http://weixin.qq.com/r/NTrt9WfEtjrJrSOW928n"}}
                            break;
                        case 'scancode_push':
                            //{"ToUserName":"gh_f21725d36b7c","FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw","CreateTime":"1501778420","MsgType":"event","Event":"scancode_push","EventKey":"rselfmenu_0_1","ScanCodeInfo":{"ScanType":"qrcode","ScanResult":"http://weixin.qq.com/r/NTrt9WfEtjrJrSOW928n"}}
                            break;
                        case 'LOCATION':
                            //{"ToUserName":"gh_f21725d36b7c","FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw","CreateTime":"1501777062","MsgType":"event","Event":"LOCATION","Latitude":"22.941250","Longitude":"112.051453","Precision":"30.000000"}
                            break;
                        case 'location_select':
                            //{"ToUserName":"gh_f21725d36b7c","FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw","CreateTime":"1501776594","MsgType":"event","Event":"location_select","EventKey":"telllaca","SendLocationInfo":{"Location_X":"22.939950942993164","Location_Y":"112.055908203125","Scale":"16","Label":"广东省云浮市云城区兴云东路156号","Poiname":"龙湖宾馆"}}
                            break;
                    }
                    return '收到事件消息：' . $message->Event;
                    break;
                case 'text':
                    //{"ToUserName":"gh_f21725d36b7c","FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw","CreateTime":"1501777366","MsgType":"text","Content":"123456","MsgId":"6450084673267708053"}
                    break;
                case 'image':
                    //{"ToUserName":"gh_f21725d36b7c","FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw","CreateTime":"1501777552","MsgType":"image","PicUrl":"http://mmbiz.qpic.cn/mmbiz_jpg/qWXicVjBibZpAmlGtGHU2hJ9K1KTRzOia7oIdEiaj5E5RprWx3ZTz1DdDg16OeAbUqiauddbHVI4YzQyxRHfSCmXKwQ/0","MsgId":"6450085472131625123","MediaId":"iRo16wK59-shpH2rPob6X7Ard_F8vd8FNegnEhB7sjocBs-g6csZGpOAtjPLRA1n"}
                    break;
                case 'voice':
                    //{"ToUserName":"gh_f21725d36b7c","FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw","CreateTime":"1501777526","MsgType":"voice","MediaId":"KkF1K7XVTfL5pvq-AU4_xet20KQMXb_TwTVlLBXg5BoT29aHnZZHME-r3oABs25Y","Format":"amr","MsgId":"6450085360037789696","Recognition":null}
                    break;
                case 'video':
                    //{"ToUserName":"gh_f21725d36b7c","FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw","CreateTime":"1501777574","MsgType":"video","MediaId":"Pih0JtI6Xcnx4Ju1XAcUaqB2H1VcCKJhvY5bdJooXU9FpvtEnAUrecqDn9L3WV9t","ThumbMediaId":"L4XlwQ7Ku32DIYAD3o0q6LdXPEc4Gt9NLBK6rrXsIi_XNMCoqKpDNrTqcmy8cp0X","MsgId":"6450085566620905638"}
                    break;
                case 'location':
                    //{"ToUserName":"gh_f21725d36b7c","FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw","CreateTime":"1501776594","MsgType":"location","Location_X":"22.939951","Location_Y":"112.055908","Scale":"16","Label":"广东省云浮市云城区兴云东路156号","MsgId":"6450081357552955415"}
                    break;
                case 'link':
                    //{"ToUserName":"gh_f21725d36b7c","FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw","CreateTime":"1501777612","MsgType":"link","Title":"茶叶内幕曝光，真相颠覆你的认知！","Description":"http://mp.weixin.qq.com/s?__biz=MzAxMTAyMjc0OQ==&mid=2651170041&idx=6&sn=1b5a4398c5461e46fc46d80b4e41d215&chksm=80b67c0bb7c1f51d61f5fd0b72c84f6c6301d634f0bf6408140e6e06da7a024506d19faf14a5&mpshare=1&scene=2&srcid=02128JQbh56Beo56RuG8GvUd#rd",
                    //"Url":"http://mp.weixin.qq.com/s?__biz=MzAxMTAyMjc0OQ==&mid=2651170041&idx=6&sn=1b5a4398c5461e46fc46d80b4e41d215&chksm=80b67c0bb7c1f51d61f5fd0b72c84f6c6301d634f0bf6408140e6e06da7a024506d19faf14a5&mpshare=1&scene=2&srcid=02128JQbh56Beo56RuG8GvUd&from=timeline#rd","MsgId":"6450085729829662891"}
                    break;
                default:
                    break;
            }
            return '收到非事件消息：' . $message->MsgType;
        });

        return $wechat->server->serve();
    }
}