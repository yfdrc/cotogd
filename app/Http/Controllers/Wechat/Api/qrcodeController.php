<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */

namespace App\Http\Controllers\Wechat\Api;

use App\Http\Controllers\Controller;
use App\Model\Wxqr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class qrcodeController extends Controller
{
    public function index(Request $request)
    {
        $cachename = 'wxqrcx'; $cachevalue = 'wxqrhs';
        $cxnr = $request['cxnr']; $xshs = $request['xshs']; is_numeric($xshs)?null:$xshs=10;
        if($request['_method']){ Cache::forever($cachename, $cxnr); Cache::forever($cachevalue, $xshs); } else{ $cxnr = Cache::get($cachename); $xshs = Cache::get($cachevalue);}
        if(is_numeric($xshs)){ if($xshs<1){$xshs = 10; }} else { $xshs = 10; }
        $cxtj = '%' . $cxnr . '%';
        $models = Wxqr::orderBy('id', 'desc')->paginate($xshs);

        return view('weixin.qr.index', [ 'tasks' => $models]);
    }

    public function create()
    {
        $fhz = drc_selectidname('kechengs','dianpu_id',auth()->user()->dianpu_id,'=','name','same');
        return view('weixin.qr.create', ['kc'=> $fhz]);
    }

    public function store(Request $request)
    {
        //{"ticket":"gQHo8DwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZ0dXbWQ4ek5lWjExMDAwMDAwN0EAAgSaQn1ZAwQAAAAA",
        //"url":"http:\/\/weixin.qq.com\/q\/02gGWmd8zNeZ110000007A"}
        $this->validate($request, ['scene_str' => 'required']);
        $name = $request['scene_str'];
        $wechat = app('wechat');
        $qrService = $wechat->qrcode;
        $result = $qrService->forever($name);
        $qr['scene_str'] = $name;
        $qr['ticket'] = $result->ticket;
        $qr['url'] = $qrService->url($qr['ticket']);
        if(!Wxqr::where('scene_str',$name)->first()) {
            Wxqr::create($qr);
        }

        return redirect(url('wechatapiqr'))->withInput(['创建永久二维码：'.$name]);
    }

    public function show($id)
    {
        $model = Wxqr::findOrFail($id);
        return view('weixin.qr.show', ['task' => $model]);
    }

    public function edit($id)
    {
        $model = Wxqr::findOrFail($id);
        return view('weixin.qr.edit',['task' => $model]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [ 'scene_str' => 'required']);
        $input = $request->all();
        $model = Wxqr::findOrFail($id);
        $model->fill($input)->save();
        return redirect(url('wechatapiqr'));
    }
}