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
                            return $this->Eventsubscribe($message);
                            break;
                        case 'unsubscribe':
                            return $this->Eventunsubscribe($message);
                            break;
                        case 'SCAN':
                            return $this->Eventscan($message);
                            break;
                        case 'scancode_push':
                            //"EventKey":"rselfmenu_0_1",
                            //"ScanCodeInfo":{"ScanType":"qrcode","ScanResult":"http://weixin.qq.com/r/NTrt9WfEtjrJrSOW928n"}}
                            break;
                        case 'CLICK':
                            //"Event":"CLICK","
                            //EventKey":"V1002_TJ"}
                            break;
                        case 'VIEW':
                            //"Event":"VIEW",
                            //"EventKey":"http://112.74.161.57/cotogd/example","MenuId":"424658939"}
                            break;
                        case 'scancode_waitmsg':
                            //"EventKey":"rselfmenu_0_0",
                            //"ScanCodeInfo":{"ScanType":"qrcode","ScanResult":"http://weixin.qq.com/r/NTrt9WfEtjrJrSOW928n"}}
                            break;
                        case 'LOCATION':
                            //"Latitude":"22.941250",
                            //"Longitude":"112.051453","
                            //Precision":"30.000000"}
                            break;
                        case 'location_select':
                            //"EventKey":"telllaca",
                            //"SendLocationInfo":{"Location_X":"22.939950942993164","Location_Y":"112.055908203125","Scale":"16","Label":"广东省云浮市云城区兴云东路156号","Poiname":"龙湖宾馆"}}
                            break;
                    }
                    return '收到事件消息：' . $message->Event;
                    break;
                case 'text':
                    return $this->Msgtext($message);
                    break;
                case 'image':
                    //"PicUrl":"http://mmbiz.qpic.cn/mmbiz_jpg/qWXicVjBibZpAmlGtGHU2hJ9K1KTRzOia7oIdEiaj5E5RprWx3ZTz1DdDg16OeAbUqiauddbHVI4YzQyxRHfSCmXKwQ/0",
                    //"MsgId":"6450085472131625123",
                    //"MediaId":"iRo16wK59-shpH2rPob6X7Ard_F8vd8FNegnEhB7sjocBs-g6csZGpOAtjPLRA1n"}
                    break;
                case 'voice':
                    //"MediaId":"KkF1K7XVTfL5pvq-AU4_xet20KQMXb_TwTVlLBXg5BoT29aHnZZHME-r3oABs25Y",
                    //"Format":"amr",
                    //"MsgId":"6450085360037789696",
                    //"Recognition":null}
                    break;
                case 'video':
                    //"MediaId":"Pih0JtI6Xcnx4Ju1XAcUaqB2H1VcCKJhvY5bdJooXU9FpvtEnAUrecqDn9L3WV9t",
                    //"ThumbMediaId":"L4XlwQ7Ku32DIYAD3o0q6LdXPEc4Gt9NLBK6rrXsIi_XNMCoqKpDNrTqcmy8cp0X",
                    //"MsgId":"6450085566620905638"}
                    break;
                case 'location':
                    //"Location_X":"22.939951",
                    //"Location_Y":"112.055908",
                    //"Scale":"16",
                    //"Label":"广东省云浮市云城区兴云东路156号",
                    //"MsgId":"6450081357552955415"}
                    break;
                case 'link':
                    //"Title":"茶叶内幕曝光，真相颠覆你的认知！",
                    //"Description":"http://mp.weixin.qq.com/s?__biz=MzAxMTAyMjc0OQ==&mid=2651170041&idx=6&sn=1b5a4398c5461e46fc46d80b4e41d215&chksm=80b67c0bb7c1f51d61f5fd0b72c84f6c6301d634f0bf6408140e6e06da7a024506d19faf14a5&mpshare=1&scene=2&srcid=02128JQbh56Beo56RuG8GvUd#rd",
                    //"Url":"http://mp.weixin.qq.com/s?__biz=MzAxMTAyMjc0OQ==&mid=2651170041&idx=6&sn=1b5a4398c5461e46fc46d80b4e41d215&chksm=80b67c0bb7c1f51d61f5fd0b72c84f6c6301d634f0bf6408140e6e06da7a024506d19faf14a5&mpshare=1&scene=2&srcid=02128JQbh56Beo56RuG8GvUd&from=timeline#rd",
                    //"MsgId":"6450085729829662891"}
                    break;
                default:
                    break;
            }
            return '收到非事件消息：' . $message->MsgType;
        });

        return $wechat->server->serve();
    }

    private function Msgtext($message){
        //"Content":"123456",
        //"MsgId":"6450084673267708053"}
        $from = $message->FromUserName;
        $content = $message->Content;
        switch (strtoupper(substr($content,0,4))){
            case 'GGXY':
                $content = str_replace('+','',$content);
                $xyidgg = substr($content,4, strlen($content) - 4);
                if (is_numeric($xyidgg)){
                    $wuser = Wxuser::find($from);
                    $todo = str_getcsv($wuser->todo,';');
                    if(count($todo) < 5){
                        return '错误提醒：系统没有查找到你需要更改上课学号。';
                    }else{
                        $xyidold = $todo[1];
                        $studytime = $todo[2];
                        if(str_contains(','.$todo[0].',',','.$xyidgg.',')){
                            if($xyidgg==$xyidold){
                                return '错误提醒：您回复的学号为默认值。';
                            } else {
                                $kouke['dianpu_id'] = $todo[3];
                                $kouke['kecheng_id'] = $todo[4];
                                $kouke['xueyuan_id'] = $xyidgg;
                                if($this->Isshangke($kouke['dianpu_id'], $kouke['xueyuan_id'], $studytime)) {
                                    return '错误信息：您回复的学号正在上课。';
                                } else {
                                    $this->addkouke($kouke, $studytime, $xyidold);
                                    $wuser->update(['todo' => '']);
                                    $this->addstudy($wuser, Xueyuan::find($kouke['xueyuan_id'])->name, Kecheng::find($kouke['kecheng_id'])->name);
                                    return '上课信息提醒：您的回复的已经处理。';
                                }
                            }
                        } else {
                            return '错误提醒：您回复的学号不正确。';
                        }
                    }
                } else {
                    return '错误提醒：您回复的学号必须为数字。';
                }
                break;
        }
        return 'error';
    }

    private function Isshangke($dianpu_id, $xueyuan_id, $sktime){
        $fhz = false;
        $kks = Kouke::where([['dianpu_id', $dianpu_id], ['xueyuan_id', $xueyuan_id]])->get();
        foreach ($kks as $kk){
            if(str_contains($kk['studTime'],$sktime)){
                $fhz = true;
                break;
            }
        }
        return $fhz;
    }

    private function Eventscan($message){
        //"EventKey":"drc",
        //"Ticket":"gQHo8DwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZ0dXbWQ4ek5lWjExMDAwMDAwN0EAAgSaQn1ZAwQAAAAA"}
        try {
            $from = $message->FromUserName;
            $kcname = $message->EventKey;
            $wuser = Wxuser::find($from);
            $tm = time();
            if ($tm - $wuser->scantime < 10) {
                return "两次扫码间隔至少10秒。";
            }
            $wuser->update(['scantime' => $tm]);
            if (Carbon::now()->minute < 30) {
                $sktime = Carbon::now()->addHour(8)->format('Y/m/d H') . ":00";
            } else {
                $sktime = Carbon::now()->addHour(9)->format('Y/m/d H') . ":00";
            }
            $jz = Jiazhang::where('tele', $wuser->remark)->first();
            if ($jz) {
                $kouke['dianpu_id'] = $jz['dianpu_id'];
                $kouke['kecheng_id'] = Kecheng::where([['dianpu_id', $kouke['dianpu_id']], ['name', $kcname]])->first()->id;
                $xys = Xueyuan::where([['dianpu_id', $kouke['dianpu_id']], ['jiazhang_id', $jz['id']]])->get();
                if ($xys) {
                    $xyxx = '';
                    $xyidarr = [];
                    $xynamearr = [];
                    foreach ($xys as $xy) {
                        if (!$this->Isshangke($kouke['dianpu_id'], $xy['id'], $sktime)) {
                            array_push($xyidarr, $xy['id']);
                            array_push($xynamearr, $xy['name']);
                            $xyxx = $xyxx . $xy['name'] . '学号为' . $xy['id'] . ';';
                        }
                    }
                    if (empty($xyidarr) ) {
                        return "错误信息：你的小朋友都在上课。";
                    } else {
                        if (count($xyidarr) > 1) {
                            $xyname = $xynamearr[0];
                            $kouke['xueyuan_id'] = $xyidarr[0];
                            $wstudyarr = str_getcsv($wuser->study, ';');
                            if ($wstudyarr[0]) {
                                for ($i = 0; $i++; $i < count($wstudyarr)) {
                                    $remarr = str_getcsv($wstudyarr[$i]);
                                    if (str_contains($remarr[1], $kcname)) {
                                        $xyidtmp = Xueyuan::where('name', $remarr[0])->first()->id;
                                        $xyname = $remarr[0];
                                        $kouke['xueyuan_id'] = $xyidtmp;
                                        break;
                                    }
                                }
                            }
                            $this->addkouke($kouke, $sktime);
                            $this->addstudy($wuser, $xyname, $kcname);
                            $wuser->update(['todo' => implode(',', $xyidarr) . ";" . $kouke['xueyuan_id'] . ";$sktime;" . $kouke['dianpu_id'] . ";" . $kouke['kecheng_id']]);
                            return "上课信息：小孩为" . $xyname . "，课程为" . $kcname . "，时间为" . $sktime . "。请注意，" . $xyxx . "如果上课小孩不对，请回复：GGXY+学号。";
                        } else {  //只有一个小朋友空闲
                            $xyname = $xynamearr[0];
                            $kouke['xueyuan_id'] = $xyidarr[0];
                            $this->addkouke($kouke, $sktime);
                            $this->addstudy($wuser, $xyname, $kcname);
                            $wuser->update(['todo' => '']);
                            return "上课信息：小孩为" . $xyname . "，课程为" . $kcname . "，时间为" . $sktime . "。";
                        }
                    }
                } else {
                    return "上课信息：没有找到小孩信息，请与工作人员联系。";
                }
            } else {
                return "上课信息：没有找到家长信息，请与工作人员联系。";
            }
        }catch (\Exception $ex)
        {
            Log::error($ex);
        }
    }

    private function Eventsubscribe($message){
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
    }

    private function Eventunsubscribe($message){
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
    }

    private  function addkouke($kouke, $newsktime, $removeid = 0){
        $fhz = 0;
        $kk = Kouke::where([['dianpu_id', $kouke['dianpu_id']], ['xueyuan_id', $kouke['xueyuan_id']], ['kecheng_id', $kouke['kecheng_id']]])->first();
        if (!$kk) {
            $kouke['studTime'] = $newsktime . ';';
            $kouke['studKs'] = 1;
            Kouke::create($kouke);
        } else {
            if (str_contains($kk['studTime'], $newsktime)) {
                $fhz = 1;
            } else {
                $kouke['studTime'] = $kk['studTime'] . $newsktime . ';';
                $kouke['studKs'] = $kk['studKs'] + 1;
                $kk->update(['studTime' => $kouke['studTime'], 'studKs' => $kouke['studKs']]);
            }
        }
        if ($removeid) {
            $kk = Kouke::where([['dianpu_id', $kouke['dianpu_id']], ['xueyuan_id', $removeid], ['kecheng_id', $kouke['kecheng_id']]])->first();
            if ($kk and str_contains($kk['studTime'], $newsktime)) {
                $kouke['studTime'] = str_replace($newsktime . ';','',$kk['studTime']);
                $kouke['studKs'] = $kk['studKs'] - 1;
                $kk->update(['studTime' => $kouke['studTime'], 'studKs' => $kouke['studKs']]);
            } else {
                $fhz = $fhz + 2;
            }
        }

        return $fhz;
    }

    private  function addstudy($wuser, $xyname, $kcname){
        $wstudy = $wuser->study;
        if (!str_contains($wstudy, $xyname)){
            if(empty($wstudy)){
                $study = "$xyname,$kcname";
            } else {
                $study = $wstudy . ";$xyname,$kcname";
            }
        } else {
            $study = '';
            $wstudyarr = str_getcsv($wstudy, ';');
            foreach ($wstudyarr as $item){
                if ( str_contains($item, $xyname)){
                    $study = $study . "$xyname,$kcname;";
                } else {
                    $study = $study . $item . ';';
                }
            }
            $study = substr($study, 0, strlen($study) - 1);
        }
        $wuser->update(['study'=>$study]);
    }
}