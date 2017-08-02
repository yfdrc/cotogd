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
use App\Model\Tempxueyuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Validator;

class XueyuanController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cachename = 'tmxueycx'; $cachevalue = 'tmxueyhs';
        $cxnr = $request['cxnr']; $xshs = $request['xshs']; is_numeric($xshs)?null:$xshs=10;
        if($request['_method']){ Cache::forever($cachename, $cxnr); Cache::forever($cachevalue, $xshs); } else{ $cxnr = Cache::get($cachename); $xshs = Cache::get($cachevalue);}
        $cxtj = '%' . $cxnr . '%';
        $models = Tempxueyuan::orderBy('id', 'asc')->where([['dianpu_id', auth()->user()->dianpu_id],['addFlag', false],['name', 'like', $cxtj]])->orwhere([['dianpu_id', auth()->user()->dianpu_id],['addFlag', false],['bh', 'like', $cxtj]])->paginate($xshs);
        return view('temp.xueyuan.index', [ 'tasks' => $models]);
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
            return view('temp.xueyuan.create',compact("dp"));
        }

        return redirect(url('tempxueyuan'))->withErrors(['你没有新建权限。']);
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
        $this->validate($request, ['jiazhang_id' => 'required', 'id' => 'required|unique:xueyuans', 'name' => 'required|unique:xueyuans']);
        $input = $request->all();
        $input['dianpu_id'] = auth()->user()->dianpu_id;
        $input['jiazhang_id'] = drc_selectremoveidpre($request['jiazhang_id']);
        $input['studKssj'] = 0;
        $input['studKszh'] = 0;
        Tempxueyuan::create($input);
        return redirect(url('tempxueyuan'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Tempxueyuan::findOrFail($id);
        return view('temp.xueyuan.show',['task' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Tempxueyuan::findOrFail($id);
        if(auth()->user()->can('manage',new Role) or (auth()->user()->can('update',new Role) and auth()->user()->dianpu_id ==$model->dianpu_id)) {
            return view('temp.xueyuan.edit',['task' => $model]);
        }
        return redirect(url('tempxueyuan'))->withErrors(['你没有编辑权限。']);
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
        if($request['sexboy'] == 'on') { $request['sexboy'] = 1; }else{ $request['sexboy'] = 0; }
        $model = Tempxueyuan::findOrFail($id);
        $this->validate($request, ['id' => 'required', 'name' => 'required']);
        $input = $request->all();
        $model->fill($input)->save();
        return redirect(url('tempxueyuan'));
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
            $model = Tempxueyuan::findOrFail($id);
            $model->delete();
            return redirect(url('tempxueyuan'));
        }
        return redirect(url('tempxueyuan'))->withErrors(['你没有删除权限。']);
    }

}