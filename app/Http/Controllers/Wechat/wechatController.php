<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Model\Jiazhang;
use App\Model\Kecheng;
use App\Model\Kouke;
use App\Model\Wxgroup;
use App\Model\Wxuser;
use App\Model\Xueyuan;
use Carbon\Carbon;
use EasyWeChat\Message\Location;
use EasyWeChat\Support\Log;

class wechatController extends Controller
{
    public function index()
    {
        $wechat = app('wechat');

        $wechat->server->setMessageHandler(function($message){
            switch ($message->MsgType) {
                case 'event':
                    switch ($message->Event){
                        case 'subscribe':
                            //{"ToUserName":"gh_f21725d36b7c",
                            //"FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw",
                            //"CreateTime":"1501775822",
                            //"MsgType":"event",
                            //"Event":"subscribe",
                            //"EventKey":null}
                            try {
                                $wechat = app('wechat');
                                $userService = $wechat->user;
                                $item = $message->FromUserName;
                                if( !Wxuser::find($item) ){
                                    $user = $userService->get($item);
                                    $wxuser['nickname'] = $user->nickname;
                                    $wxuser['remark'] = $user->remark;
                                    $wxuser['address'] = $user->province . $user->city;
                                    $wxuser['group_id'] = $user->groupid;
                                    $wxuser['subtime'] = $user->subscribe_time;
                                    $wxuser['openid'] = $item;
                                    Wxuser::create($wxuser);
                                    $gr = Wxgroup::find(0); $gr->count +=1; $gr->save();
                                }
                            }catch (\Exception $ex)
                            {
                                Log::error($ex);
                            }
                            break;
                        case 'unsubscribe':
                            //{"ToUserName":"gh_f21725d36b7c",
                            //"FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw",
                            //"CreateTime":"1501775503",
                            //"MsgType":"event",
                            //"Event":"unsubscribe",
                            //"EventKey":null}
                            try {
                                $item = $message->FromUserName;
                                $wxuser=Wxuser::find($item);
                                $gr = Wxgroup::find($wxuser->group_id); $gr->count +=-1; $gr->save();
                                $wxuser->delete();
                            }catch (\Exception $ex)
                            {
                                Log::error($ex);
                            }
                            break;
                        case 'CLICK':
                            //{"ToUserName":"gh_f21725d36b7c","FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw","CreateTime":"1501776202","MsgType":"event","Event":"CLICK","EventKey":"V1002_TJ"}
                            break;
                        case 'VIEW':
                            //{"ToUserName":"gh_f21725d36b7c","FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw","CreateTime":"1501776210","MsgType":"event","Event":"VIEW","EventKey":"http://112.74.161.57/cotogd/example","MenuId":"424658939"}
                            break;
                        case 'SCAN':
                            //"EventKey":"drc",
                            //"Ticket":"gQHo8DwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZ0dXbWQ4ek5lWjExMDAwMDAwN0EAAgSaQn1ZAwQAAAAA"}
                            $from = $message->FromUserName;
                            $kcname = $message->EventKey;
                            $wuser = Wxuser::find($from);
                            $tm = time();
                            if($tm - $wuser->scantime < 10){
                                return "两次扫码间隔至少10秒。";
                            }
                            $wuser->update(['scantime'=>$tm]);
                            if(Carbon::now()->minute<30){
                                $sktime = Carbon::now()->addHour(8)->format('Y/m/d H').":00";
                            } else {
                                $sktime = Carbon::now()->addHour(9)->format('Y/m/d H').":00";
                            }
                            $jz = Jiazhang::where('tele', $wuser->remark)->first();
                            if($jz) {
                                $kouke['dianpu_id'] = $jz['dianpu_id'];
                                $kouke['kecheng_id'] = Kecheng::where([['dianpu_id',$kouke['dianpu_id']],['name',$kcname]])->first()->id;
                                $xys = Xueyuan::where([['dianpu_id',$kouke['dianpu_id']],['jiazhang_id', $jz['id']]])->get();
                                if($xys) {
                                    if (count($xys) > 1) {
                                        $xyxx ='';
                                        $xyidarr = [];
                                        $xynamearr = [];
                                        foreach ($xys as $xy) {
                                            array_push($xyidarr , $xy['id']);
                                            array_push($xynamearr , $xy['name']);
                                            $xyxx = $xyxx . $xy['name'] . '学号为' .$xy['id'] . ';';
                                        }
                                        $xyname = $xynamearr[0];
                                        $kouke['xueyuan_id'] = $xyidarr[0];
                                        $kk = Kouke::where([['dianpu_id',$kouke['dianpu_id']],['xueyuan_id',$kouke['xueyuan_id']],['kecheng_id',$kouke['kecheng_id']]])->first();
                                        if(!$kk){
                                            //没有第一学员首次扣课记录
                                            $kouke['studTime'] = $sktime . ';';
                                            $kouke['studKs'] = 1;
                                            Kouke::create($kouke);
                                        } else {
                                            //已有第一学员首次扣课记录
                                            if(str_contains($kk['studTime'],$sktime)){
                                                //已有第一学员本次扣课信息
                                                $xyname = $xynamearr[1];
                                                $kouke['xueyuan_id'] = $xyidarr[1];
                                                $kk2 = Kouke::where([['dianpu_id',$kouke['dianpu_id']],['xueyuan_id',$kouke['xueyuan_id']],['kecheng_id',$kouke['kecheng_id']]])->first();
                                                if(!$kk2){
                                                    //没有第二小孩首次扣课信息
                                                    $kouke['studTime'] = $sktime . ';';
                                                    $kouke['studKs'] = 1;
                                                    Kouke::create($kouke);
                                                } else {
                                                    //已有第二小孩首次扣课信息
                                                    if (str_contains($kk2['studTime'], $sktime)) {
                                                        return "上课信息：同一家长同一时段同一课程系统最多允许两个小朋友上课，请你不要重复扫码。";
                                                    }else{
                                                        //没有第二学员本次扣课信息
                                                        $kouke['studTime'] = $kk2['studTime'] . $sktime . ';';
                                                        $kouke['studKs'] = $kk2['studKs'] + 1;
                                                        $kk2->update(['studTime'=>$kouke['studTime'],'studKs'=>$kouke['studKs']]);
                                                    }
                                                }
                                                return "上课信息：小孩为". $xyname."，课程为".$kcname."，时间为".$sktime."。";
                                            }else{
                                                //没有第一学员本次扣课信息
                                                $kouke['studTime'] = $kk['studTime'] . $sktime . ';';
                                                $kouke['studKs'] = $kk['studKs'] + 1;
                                                $kk->update(['studTime'=>$kouke['studTime'],'studKs'=>$kouke['studKs']]);
                                            }
                                        }
                                        return "上课信息：小孩为". $xyname."，课程为".$kcname."，时间为".$sktime."。请注意，".$xyxx."如果上课小孩不对，请回复：GGXY+学号。";
                                    }else{
                                        $xyname = $xys->first()->name;
                                        $kouke['xueyuan_id'] = $xys->first()->id;
                                        $kk = Kouke::where([['dianpu_id',$kouke['dianpu_id']],['xueyuan_id',$kouke['xueyuan_id']],['kecheng_id',$kouke['kecheng_id']]])->first();
                                        if(!$kk){
                                            $kouke['studTime'] = $sktime . ';';
                                            $kouke['studKs'] = 1;
                                            Kouke::create($kouke);
                                        } else {
                                            if(str_contains($kk['studTime'],$sktime)){
                                                return "上课信息：系统只登记了一个小朋友资料，请你不要重复扫码。";
                                            }else{
                                                $kouke['studTime'] = $kk['studTime'] . $sktime . ';';
                                                $kouke['studKs'] = $kk['studKs'] + 1;
                                                $kk->update(['studTime'=>$kouke['studTime'],'studKs'=>$kouke['studKs']]);
                                            }
                                        }
                                        return "上课信息：小孩为". $xyname."，课程为".$kcname."，时间为".$sktime."。";
                                    }
                                } else {
                                    return "上课信息：没有找到小孩信息，请与工作人员联系。";
                                }
                            } else {
                                return "上课信息：没有找到家长信息，请与工作人员联系。";
                            }
                            break;
                        case 'scancode_push':
                            //{"ToUserName":"gh_f21725d36b7c","FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw","CreateTime":"1501778420","MsgType":"event","Event":"scancode_push","EventKey":"rselfmenu_0_1","ScanCodeInfo":{"ScanType":"qrcode","ScanResult":"http://weixin.qq.com/r/NTrt9WfEtjrJrSOW928n"}}
                            return '';
                            break;
                        case 'scancode_waitmsg':
                            //{"ToUserName":"gh_f21725d36b7c","FromUserName":"o4zG9wY6IC_d-AGw_iZEeF3OlFhw","CreateTime":"1501778410","MsgType":"event","Event":"scancode_waitmsg","EventKey":"rselfmenu_0_0","ScanCodeInfo":{"ScanType":"qrcode","ScanResult":"http://weixin.qq.com/r/NTrt9WfEtjrJrSOW928n"}}
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