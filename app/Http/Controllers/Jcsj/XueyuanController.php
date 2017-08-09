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
use App\Model\Xueyuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Validator;

class XueyuanController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cachename = 'xueycx'; $cachevalue = 'xueyhs';
        $cxnr = $request['cxnr']; $xshs = $request['xshs']; is_numeric($xshs)?null:$xshs=10;
        if($request['_method']){ Cache::forever($cachename, $cxnr); Cache::forever($cachevalue, $xshs); } else{ $cxnr = Cache::get($cachename); $xshs = Cache::get($cachevalue);}
        if(is_numeric($xshs)){ if($xshs<1){$xshs = 10; }} else { $xshs = 10; }
        $cxtj = '%' . $cxnr . '%';
//        if(auth()->user()->can('manage',new Role)) {
//            $models = xueyuan::orderBy('id', 'desc')->where('name', 'like', $cxtj)->orwhere('bh', 'like', $cxtj)->paginate($xshs);
//        }else{
//            $models = xueyuan::orderBy('id', 'desc')->where([['dianpu_id', auth()->user()->dianpu_id],['name', 'like', $cxtj]])->orwhere([['dianpu_id', auth()->user()->dianpu_id],['bh', 'like', $cxtj]])->paginate($xshs);
//        }
        $models = DB::table('xueyuans')
            ->leftJoin("jiazhangs", "jiazhang_id", "=", "jiazhangs.id")
            ->select(
                'xueyuans.*',
                'jiazhangs.name as jzname'
            )
            ->orderBy('id', 'desc')
            ->where([['xueyuans.dianpu_id', auth()->user()->dianpu_id],['jiazhangs.name', 'like', $cxtj]])
            ->orwhere([['xueyuans.dianpu_id', auth()->user()->dianpu_id],['xueyuans.name', 'like', $cxtj]])
            ->orwhere([['xueyuans.dianpu_id', auth()->user()->dianpu_id],['xueyuans.bh', 'like', $cxtj]])
            ->paginate($xshs);
        return view('xueyuan.index', [ 'tasks' => $models]);
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
            return view('xueyuan.create',compact("dp"));
        }

        return redirect(url('xueyuan'))->withErrors(['你没有新建权限。']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request['sexboy'] == 'on') { $request['sexboy'] = 1; }else{ $request['sexboy'] = 0; }
        $this->validate($request, ['jiazhang_id' => 'required', 'bh' => 'required|unique:xueyuans', 'name' => 'required|unique:xueyuans']);
        $input = $request->all();
        $input['dianpu_id'] = auth()->user()->dianpu_id;
        $input['jiazhang_id'] = drc_selectremoveidpre($request['jiazhang_id']);
        $input['studKssj'] = 0;
        $input['studKszh'] = 0;
        Xueyuan::create($input);
        return redirect(url('xueyuan'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = xueyuan::findOrFail($id);
        return view('xueyuan.show',['task' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = xueyuan::findOrFail($id);
        if(auth()->user()->can('manage',new Role) or (auth()->user()->can('update',new Role) and auth()->user()->dianpu_id ==$model->dianpu_id)) {
            return view('xueyuan.edit',['task' => $model]);
        }
        return redirect(url('xueyuan'))->withErrors(['你没有编辑权限。']);
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
//        if($request['sexboy'] == 'on') { $request['sexboy'] = 1; }else{ $request['sexboy'] = 0; }
        $model = xueyuan::findOrFail($id);
        $this->validate($request, ['bh' => 'required', 'name' => 'required']);
        $input = $request->all();
        $model->fill($input)->save();
        return redirect(url('xueyuan'));
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
            $model = jiazhang::findOrFail($id);
            $model->delete();
            return redirect(url('xueyuan'));
        }
        return redirect(url('xueyuan'))->withErrors(['你没有删除权限。']);
    }

}