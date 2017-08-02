<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */
namespace App\Http\Controllers\Jcsj;

use App\Http\Controllers\Controller;
use App\Model\Role;
use App\Model\Xieyi;
use App\Xueyuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Validator;

class XieyiController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cachename = 'xieycx'; $cachevalue = 'xieyhs';
        $cxnr = $request['cxnr']; $xshs = $request['xshs']; is_numeric($xshs)?null:$xshs=10;
        if($request['_method']){ Cache::forever($cachename, $cxnr); Cache::forever($cachevalue, $xshs); } else{ $cxnr = Cache::get($cachename); $xshs = Cache::get($cachevalue);}
        if(is_numeric($xshs)){ if($xshs<1){$xshs = 10; }} else { $xshs = 10; }
        $cxtj = '%' . $cxnr . '%';
//        if(auth()->user()->can('manage',new Role)) {
//            $models = xieyi::orderBy('id', 'desc')->where('name', 'like', $cxtj)->paginate($xshs);
//        }else{
//            $models = xieyi::orderBy('id', 'desc')->where('dianpu_id', auth()->user()->dianpu_id)->where('name', 'like', $cxtj)->paginate($xshs);
//        }
        $models = DB::table('xieyis')
            ->leftJoin("jiazhangs", "jiazhang_id", "=", "jiazhangs.id")
            ->select(
                'xieyis.*',
                'jiazhangs.name as jzname'
            )
            ->orderBy('id', 'desc')
            ->where([['xieyis.dianpu_id', auth()->user()->dianpu_id],['jiazhangs.name', 'like', $cxtj]])
            ->orwhere([['xieyis.dianpu_id', auth()->user()->dianpu_id],['xieyis.name', 'like', $cxtj]])
            ->orwhere([['xieyis.dianpu_id', auth()->user()->dianpu_id],['kebao', 'like', $cxtj]])
            ->paginate($xshs);
        return view('xieyi.index', [ 'tasks' => $models]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->can('create',new Role)){
            $dp = drc_selectidname('jiazhangs','dianpu_id',auth()->user()->dianpu_id);
            return view('xieyi.create',compact("dp"));
        }

        return redirect(url('xieyi'))->withErrors(['你没有新建权限。']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request['isZZ'] == 'on') { $request['isZZ'] = 1; }else{ $request['isZZ'] = 0; }
        $this->validate($request, ['jiazhang_id' => 'required', 'name' => 'required|unique:xieyis', 'ksZw' => 'required','ksYw' => 'required', 'jinE' => 'required']);
        $input = $request->all();
        $model = new Xieyi();
        $model['dianpu_id'] = auth()->user()->dianpu_id;
        $input['jiazhang_id'] = drc_selectremoveidpre($request['jiazhang_id']);
        if($request['guWen1'] != '') { $model['guWen1'] = $request['guWen1']; }else{ $model['guWen1'] = null; }
        if($request['guWen2'] != '') { $model['guWen2'] = $request['guWen2']; }else{ $model['guWen2'] = null; }
        $model->fill($input)->save();
        return redirect(url('xieyi'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = xieyi::findOrFail($id);
        return view('xieyi.show',['task' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = xieyi::findOrFail($id);
        if(auth()->user()->can('manage',new Role) or (auth()->user()->can('update',new Role) and auth()->user()->dianpu_id ==$model->dianpu_id)) {
            return view('xieyi.edit',['task' => $model]);
        }
        return redirect(url('xieyi'))->withErrors(['你没有编辑权限。']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request['isZZ'] == 'on') { $request['isZZ'] = 1; }else{ $request['isZZ'] = 0; }
        $model = xieyi::findOrFail($id);
        $this->validate($request, [ 'ksZw' => 'required','ksYw' => 'required', 'jinE' => 'required']);
        $input = $request->all();
        if($request['guWen1'] != '') { $model['guWen1'] = $request['guWen1']; }else{ $model['guWen1'] = null; }
        if($request['guWen2'] != '') { $model['guWen2'] = $request['guWen2']; }else{ $model['guWen2'] = null; }
        $model->fill($input)->save();
        return redirect(url('xieyi'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->can('manage',new Role)) {
            $model = xieyi::findOrFail($id);
            $model->delete();
            return redirect(url('xieyi'));
        }
        return redirect(url('xueyuan'))->withErrors(['你没有删除权限。']);
    }

}