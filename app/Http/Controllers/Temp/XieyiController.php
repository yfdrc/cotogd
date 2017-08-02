<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */
namespace App\Http\Controllers\Temp;

use App\Http\Controllers\Controller;
use App\Model\Role;
use App\Model\Tempxieyi;
use App\Xueyuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Validator;

class XieyiController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cachename = 'tmxieycx'; $cachevalue = 'tmxieyhs';
        $cxnr = $request['cxnr']; $xshs = $request['xshs']; is_numeric($xshs)?null:$xshs=10;
        if($request['_method']){ Cache::forever($cachename, $cxnr); Cache::forever($cachevalue, $xshs); } else{ $cxnr = Cache::get($cachename); $xshs = Cache::get($cachevalue);}
        $cxtj = '%' . $cxnr . '%';
        $models = Tempxieyi::orderBy('id', 'asc')->where([['dianpu_id', auth()->user()->dianpu_id],['addFlag', false],['name', 'like', $cxtj]])->paginate($xshs);
        return view('temp.xieyi.index', [ 'tasks' => $models]);
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
            return view('temp.xieyi.create',compact("dp"));
        }

        return redirect(url('tempxieyi'))->withErrors(['你没有新建权限。']);
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
        $this->validate($request, ['jiazhang_id' => 'required', 'id' => 'required|unique:xieyis', 'ksZw' => 'required','ksYw' => 'required', 'jinE' => 'required']);
        $input = $request->all();
        $model = new Tempxieyi();
        $model['dianpu_id'] = auth()->user()->dianpu_id;
        $input['jiazhang_id'] = drc_selectremoveidpre($request['jiazhang_id']);
        if($request['guWen1'] != '') { $model['guWen1'] = $request['guWen1']; }else{ $model['guWen1'] = null; }
        if($request['guWen2'] != '') { $model['guWen2'] = $request['guWen2']; }else{ $model['guWen2'] = null; }
        $model->fill($input)->save();
        return redirect(url('tempxieyi'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Tempxieyi::findOrFail($id);
        return view('temp.xieyi.show',['task' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Tempxieyi::findOrFail($id);
        if(auth()->user()->can('manage',new Role) or (auth()->user()->can('update',new Role) and auth()->user()->dianpu_id ==$model->dianpu_id)) {
            return view('temp.xieyi.edit',['task' => $model]);
        }
        return redirect(url('tempxieyi'))->withErrors(['你没有编辑权限。']);
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
        $model = Tempxieyi::findOrFail($id);
        $this->validate($request, ['id' => 'required', 'ksZw' => 'required','ksYw' => 'required', 'jinE' => 'required']);
        $input = $request->all();
        if($request['guWen1'] != '') { $model['guWen1'] = $request['guWen1']; }else{ $model['guWen1'] = null; }
        if($request['guWen2'] != '') { $model['guWen2'] = $request['guWen2']; }else{ $model['guWen2'] = null; }
        $model->fill($input)->save();
        return redirect(url('tempxieyi'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->can('delete',new Role)) {
            $model = Tempxieyi::findOrFail($id);
            $model->delete();
            return redirect(url('tempxieyi'));
        }
        return redirect(url('tempxueyuan'))->withErrors(['你没有删除权限。']);
    }

}