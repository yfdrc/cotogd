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
use App\Model\Tempkouke;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Validator;

class KoukeController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cachename = 'tmkoukcx'; $cachevalue = 'tmkoukhs';
        $cxnr = $request['cxnr']; $xshs = $request['xshs']; is_numeric($xshs)?null:$xshs=10;
        if($request['_method']){ Cache::forever($cachename, $cxnr); Cache::forever($cachevalue, $xshs); } else{ $cxnr = Cache::get($cachename); $xshs = Cache::get($cachevalue);}
        $cxtj = '%' . $cxnr . '%';
        $models = Tempkouke::orderBy('id', 'desc')->where([['dianpu_id', auth()->user()->dianpu_id],['addFlag', false],['studTime', 'like', $cxtj]])->paginate($xshs);
        return view('temp.kouke.index', [ 'tasks' => $models]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->can('create',new Role)){
            $dp = drc_selectidname('xueyuans','dianpu_id',auth()->user()->dianpu_id);
            $kc = drc_selectidname('kechengs','dianpu_id',auth()->user()->dianpu_id);
            return view('temp.kouke.create',compact("dp","kc"));
        }

        return redirect(url('tempkouke'))->withErrors(['你没有新建权限。']);    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['xueyuan_id' => 'required','kecheng_id' => 'required', 'studTime' => 'required','studKs' => 'required', 'kcQz' => 'required' ]);
        $input = $request->all();
        $input['dianpu_id'] = auth()->user()->dianpu_id;
        $input['xueyuan_id'] = drc_selectremoveidpre($request['xueyuan_id']);
        $input['kecheng_id'] = drc_selectremoveidpre($request['kecheng_id']);
        Tempkouke::create($input);
        return redirect(url('tempkouke'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Tempkouke::findOrFail($id);
        return view('temp.kouke.show',['task' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Tempkouke::findOrFail($id);
        if(auth()->user()->can('manage',new Role) or (auth()->user()->can('update',new Role) and auth()->user()->dianpu_id ==$task->dianpu_id)) {
            $dp = drc_selectidname('xueyuans','dianpu_id',auth()->user()->dianpu_id);
            $kc = drc_selectidname('kechengs','dianpu_id',auth()->user()->dianpu_id);
            return view('temp.kouke.edit',compact("task","dp","kc"));
        }
        return redirect(url('tempkouke'))->withErrors(['你没有编辑权限。']);
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
        $model = Tempkouke::findOrFail($id);
        $this->validate($request, ['xueyuan_id' => 'required','kecheng_id' => 'required', 'studTime' => 'required','studKs' => 'required', 'kcQz' => 'required' ]);
        $input = $request->all();
        $input['xueyuan_id'] = drc_selectremoveidpre($request['xueyuan_id']);
        $input['kecheng_id'] = drc_selectremoveidpre($request['kecheng_id']);
        $input['addFlag'] = false;
        $model->fill($input)->save();
        return redirect(url('tempkouke'));
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
            $model = Tempkouke::findOrFail($id);
            $model->delete();
            return redirect(url('tempkouke'));
        }
        return redirect(url('tempkouke'))->withErrors(['你没有删除权限。']);
    }

}