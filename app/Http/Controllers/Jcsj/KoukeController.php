<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */
namespace App\Http\Controllers\Jcsj;

use App\Http\Controllers\Controller;
use App\Model\Kouke;
use App\Model\Role;
use App\Xueyuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Validator;

class KoukeController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cachename = 'koukcx'; $cachevalue = 'koukhs';
        $cxnr = $request['cxnr']; $xshs = $request['xshs']; is_numeric($xshs)?null:$xshs=10;
        if($request['_method']){ Cache::forever($cachename, $cxnr); Cache::forever($cachevalue, $xshs); } else{ $cxnr = Cache::get($cachename); $xshs = Cache::get($cachevalue);}
        if(is_numeric($xshs)){ if($xshs<1){$xshs = 10; }} else { $xshs = 10; }
        $cxtj = '%' . $cxnr . '%';
//        if(auth()->user()->can('manage',new Role)) {
//            $models = kouke::orderBy('id', 'desc')->where('studTime', 'like', $cxtj)->paginate($xshs);
//        }else{
//            $models = kouke::orderBy('id', 'desc')->where([['dianpu_id', auth()->user()->dianpu_id],['studTime', 'like', $cxtj]])->paginate($xshs);
//        }
        $models = DB::table('koukes')
            ->leftJoin("xueyuans", "xueyuan_id", "=", "xueyuans.id")
            ->leftJoin("jiazhangs", "jiazhang_id", "=", "jiazhangs.id")
            ->leftJoin("kechengs", "kecheng_id", "=", "kechengs.id")
            ->select(
                'koukes.*',
                'jiazhangs.name as jzname',
                'xueyuans.name as xyname',
                'xueyuans.bh as xybh',
                'kechengs.name as kcname'
            )
            ->orderBy('updated_at', 'desc')
            ->where([['koukes.dianpu_id', auth()->user()->dianpu_id],['jiazhangs.name', 'like', $cxtj]])
            ->orwhere([['koukes.dianpu_id', auth()->user()->dianpu_id],['xueyuans.name', 'like', $cxtj]])
            ->orwhere([['koukes.dianpu_id', auth()->user()->dianpu_id],['xueyuans.bh', 'like', $cxtj]])
            ->orwhere([['koukes.dianpu_id', auth()->user()->dianpu_id],['kechengs.name', 'like', $cxtj]])
            ->orwhere([['koukes.dianpu_id', auth()->user()->dianpu_id],['studTime', 'like', $cxtj]])
            ->paginate($xshs);
        return view('kouke.index', [ 'tasks' => $models]);
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
            return view('kouke.create',compact("dp","kc"));
        }

        return redirect(url('kouke'))->withErrors(['你没有新建权限。']);    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['xueyuan_id' => 'required','kecheng_id' => 'required', 'studTime' => 'required','studKs' => 'required']);
        $input = $request->all();
        $input['dianpu_id'] = auth()->user()->dianpu_id;
        $input['xueyuan_id'] = drc_selectremoveidpre($request['xueyuan_id']);
        $input['kecheng_id'] = drc_selectremoveidpre($request['kecheng_id']);
        kouke::create($input);
        return redirect(url('kouke'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = kouke::findOrFail($id);
        return view('kouke.show',['task' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = kouke::findOrFail($id);
        if(auth()->user()->can('manage',new Role) or (auth()->user()->can('update',new Role) and auth()->user()->dianpu_id ==$task->dianpu_id)) {
            $dp = drc_selectidname('xueyuans','dianpu_id',auth()->user()->dianpu_id);
            $kc = drc_selectidname('kechengs','dianpu_id',auth()->user()->dianpu_id);
            return view('kouke.edit',compact("task","dp","kc"));
        }
        return redirect(url('kouke'))->withErrors(['你没有编辑权限。']);
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
        $model = kouke::findOrFail($id);
        $this->validate($request, ['studTime' => 'required','studKs' => 'required']);
        $input = $request->all();
        $model->fill($input)->save();
        return redirect(url('kouke'));
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
            $model = kouke::findOrFail($id);
            $model->delete();
            return redirect(url('kouke'));
        }
        return redirect(url('kouke'))->withErrors(['你没有删除权限。']);
    }

}