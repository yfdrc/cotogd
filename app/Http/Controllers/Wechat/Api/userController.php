<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */

namespace App\Http\Controllers\Wechat\Api;

use App\Http\Controllers\Controller;
use App\Model\Role;
use App\Model\Wxgroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Model\Wxuser;

class userController extends Controller
{
    public function index(Request $request)
    {
        $cachename = 'wxyhcx'; $cachevalue = 'wxyhhs';
        $cxnr = $request['cxnr']; $xshs = $request['xshs']; is_numeric($xshs)?null:$xshs=10;
        if($request['_method']){ Cache::forever($cachename, $cxnr); Cache::forever($cachevalue, $xshs); } else{ $cxnr = Cache::get($cachename); $xshs = Cache::get($cachevalue);}
        if(is_numeric($xshs)){ if($xshs<1){$xshs = 10; }} else { $xshs = 10; }
        $cxtj = '%' . $cxnr . '%';
        $models = Wxuser::orderBy('subtime', 'desc')->paginate($xshs);

        return view('weixin.user.index', [ 'tasks' => $models]);
    }

    public function create()
    {
        try {
            $wechat = app('wechat');
            $userService = $wechat->user;
            $userobj =\GuzzleHttp\json_decode($userService->lists());
//            $total = $userobj->total;
//            $count = $userobj->count;
//            $nextopenid = $userobj->next_openid;
            $openid = $userobj->data->openid;
            foreach ($openid as $item){
                if( !Wxuser::find($item) ){
                    $user = $userService->get($item);
                    $wxuser['nickname'] = $user->nickname;
                    $wxuser['remark'] = $user->remark;
                    $wxuser['address'] = $user->province . $user->city;
                    $wxuser['group_id'] = $user->groupid;
                    $wxuser['subtime'] = $user->subscribe_time;
                    $wxuser['openid'] = $item;
                    Wxuser::create($wxuser);
                }
            }
        }catch (\Exception $ex)
        {
            $userlists = "错误：$ex";
        }
        return view('weixin.user.create', ['ts' => '一次性写入微信用户成功。']);
    }
    public function store(Request $request)
    {
    }

    public function show($id)
    {
        $model = Wxuser::findOrFail($id);
        return view('weixin.user.show',['task' => $model]);
    }

    public function edit($id)
    {
        $fhz = drc_selectidname('wxgroups');
        $model = Wxuser::findOrFail($id);
        if(auth()->user()->can('update',new Role)) {
            return view('weixin.user.edit',['task' => $model, 'gp'=>$fhz]);
        }
        return redirect(url('wechatapiuser'))->withErrors(['你没有编辑权限。']);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $input['group_id'] = drc_selectremoveidpre($request['group_id']);
        $model = Wxuser::findOrFail($id);
        $this->validate($request, [ 'remark' => 'required']);
        if($input['remark']!=$model['remark']){
            $wechat = app('wechat');
            $userService = $wechat->user;
            $userService->remark($id, $input['remark']);
        }
        if($input['group_id']!=$model['group_id']){
            $gr = Wxgroup::find($input['group_id']); $gr->count +=1; $gr->save();
            $gr = Wxgroup::find($model['group_id']); $gr->count +=-1; $gr->save();
            $wechat = app('wechat');
            $groupService = $wechat->user_group;
            $groupService->moveUser($id, $input['group_id']);
        }
        $model->fill($input)->save();
        return redirect(url('wechatapiuser'));
    }

    public function destroy($id)
    {
        if(auth()->user()->can('admin',new Role())) {
            $model = Wxuser::findOrFail($id);
            $model->delete();
            return redirect(url('wechatapiuser'));
        }
        return redirect(url('wechatapiuser'))->withErrors(['你没有删除权限。']);
    }
}