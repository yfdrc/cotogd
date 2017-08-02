<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */
namespace App\Http\Controllers\Xtgl;

use App\Http\Controllers\Controller;
use App\Model\Kecheng;
use App\Model\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Validator;

class KechengController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cachename = 'kccx'; $cachevalue = 'kchs';
        $cxnr = $request['cxnr']; $xshs = $request['xshs']; is_numeric($xshs)?null:$xshs=10;
        if($request['_method']){ Cache::forever($cachename, $cxnr); Cache::forever($cachevalue, $xshs); } else{ $cxnr = Cache::get($cachename); $xshs = Cache::get($cachevalue);}
        if(is_numeric($xshs)){ if($xshs<1){$xshs = 10; }} else { $xshs = 10; }
        $cxtj = '%' . $cxnr . '%';
        if(auth()->user()->can('manage',new Role)) {
            $models = kecheng::orderBy('name', 'asc')->where('name', 'like', $cxtj)->paginate($xshs);
        }else{
            $models = kecheng::orderBy('name', 'asc')->where([['dianpu_id', auth()->user()->dianpu_id],['name', 'like', $cxtj]])->paginate($xshs);
        }
        return view('kecheng.index', [ 'tasks' => $models]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->can('manage',new Role)){
            $fhz = drc_selectidname('dianpus');
            return view('kecheng.create')->with('dp', $fhz);
        }elseif(auth()->user()->can('dianzhang',new Role)){
            $fhz = drc_selectidname('dianpus','id',auth()->user()->dianpu_id);
            return view('kecheng.create')->with('dp', $fhz);
        }

        return redirect(url('kecheng'))->withErrors(['你没有新建权限。']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['dianpu_id' => 'required', 'name' => 'required|unique:kechengs',  'ageMin' => 'required', 'ageMax' => 'required' ]);
        $input = $request->all();
        $input['dianpu_id'] = drc_selectremoveidpre($request['dianpu_id']);
        kecheng::create($input);
        return redirect(url('kecheng'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = kecheng::findOrFail($id);
        return view('kecheng.show',['task' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = kecheng::findOrFail($id);
        if(auth()->user()->can('manage',new Role) or (auth()->user()->can('dianzhang',new Role) and auth()->user()->dianpu_id ==$model->dianpu_id)) {
            return view('kecheng.edit',['task' => $model]);
        }
        return redirect(url('kecheng'))->withErrors(['你没有编辑权限。']);
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
        $model = kecheng::findOrFail($id);
        $this->validate($request, ['name' => 'required',  'ageMin' => 'required', 'ageMax' => 'required' ]);
        $input = $request->all();
        $model->fill($input)->save();
        return redirect(url('kecheng'));
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
            $model = kecheng::findOrFail($id);
            $model->delete();
            return redirect(url('kecheng'));
        }
        return redirect(url('kecheng'))->withErrors(['你没有删除权限。']);
    }

}