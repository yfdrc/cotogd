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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Model\Wxgroup;

class usergroupController extends Controller
{
    public function index(Request $request)
    {
        $cachename = 'wxyhzcx'; $cachevalue = 'wxyhzhs';
        $cxnr = $request['cxnr']; $xshs = $request['xshs']; is_numeric($xshs)?null:$xshs=10;
        if($request['_method']){ Cache::forever($cachename, $cxnr); Cache::forever($cachevalue, $xshs); } else{ $cxnr = Cache::get($cachename); $xshs = Cache::get($cachevalue);}
        if(is_numeric($xshs)){ if($xshs<1){$xshs = 10; }} else { $xshs = 10; }
        $cxtj = '%' . $cxnr . '%';
        $models = Wxgroup::orderBy('id', 'desc')->paginate($xshs);

        return view('weixin.group.index', [ 'tasks' => $models]);
    }

    public function create()
    {
        return view('weixin.group.create');
    }

    public function store(Request $request)
    {
        //{"group":{"id":104,"name":"drczu2"}}
        try {
            $name = request()->get("groupname");
            $wechat = app('wechat');
            $groupService = $wechat->user_group;
            $group = $groupService->create($name);
            $groupfhz = "创建用户组：$name ；写入数据库：";
            if (!Wxgroup::find($group->id)) {
                $wxgroup['id'] = $group->id;
                $wxgroup['name'] = $group->name;
                $wxgroup['count'] = $group->count;
                $groupfhz += Wxgroup::create($wxgroup);
            }
            return redirect(url('wechatapigroup'));
        }catch (\Exception $ex) {
            $groupfhz += $ex;
            return view('weixin.group.create', ['ts' => $groupfhz]);
        }
    }

    public function edit($id)
    {
        $model = Wxgroup::findOrFail($id);
        return view('weixin.group.edit', [ 'task' => $model]);
    }

    public function update(Request $request, $id)
    {
        try {
            $input = $request->all();
            $wechat = app('wechat');
            $groupService = $wechat->user_group;
            $groupfhz = $groupService->update($id, $input['name']);

            $model = Wxgroup::findOrFail($id);
            $this->validate($request, ['name' => 'required']);
            $model->fill($input)->save();
            return redirect(url('wechatapigroup'));
        } catch (\Exception $ex) {
            $groupfhz += $ex;
            return view('weixin.group.edit', ['ts' => $groupfhz]);
        }
    }
    public function show($id)
    {
        $model = Wxgroup::findOrFail($id);
        return view('weixin.group.show',['task' => $model]);
    }

    public function destroy($id)
    {
        if(auth()->user()->can('admin',new Role)) {
            $wechat = app('wechat');
            $groupService = $wechat->user_group;
            $groupService->delete($id);

            $model = Wxgroup::findOrFail($id);
            $model->delete();
            return redirect(url('wechatapigroup'));
        }
        return redirect(url('wechatapigroup'))->withErrors(['你没有删除权限。']);
    }
}