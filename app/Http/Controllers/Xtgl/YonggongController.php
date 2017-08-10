<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */
namespace App\Http\Controllers\Xtgl;

use App\Http\Controllers\Controller;
use App\Model\Role;
use App\Model\Yonggong;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Validator;

class YonggongController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cachename = 'ygcx'; $cachevalue = 'yghs';
        $cxnr = $request['cxnr']; $xshs = $request['xshs']; is_numeric($xshs)?null:$xshs=10;
        if($request['_method']){ Cache::forever($cachename, $cxnr); Cache::forever($cachevalue, $xshs); } else{ $cxnr = Cache::get($cachename); $xshs = Cache::get($cachevalue);}
        if(is_numeric($xshs)){ if($xshs<1){$xshs = 10; }} else { $xshs = 10; }
        $cxtj = '%' . $cxnr . '%';
//        if(auth()->user()->can('manage',new Role)) {
//            $models = yonggong::orderBy('name', 'asc')->where('name', 'like', $cxtj)->paginate($xshs);
//        }else{
        $models = yonggong::orderBy('name', 'asc')->where([['dianpu_id', auth()->user()->dianpu_id],['name', 'like', $cxtj]])->orwhere([['dianpu_id', auth()->user()->dianpu_id],['tele', 'like', $cxtj]])->paginate($xshs);
//        }
        return view('yonggong.index', [ 'tasks' => $models]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        if(auth()->user()->can('manage',new Role)){
//            $fhz = drc_selectidname('dianpus');
//            return view('yonggong.create')->with('dp', $fhz);
//        }else
        if(auth()->user()->can('dianzhang',new Role)){
            $fhz = drc_selectidname('dianpus','id',auth()->user()->dianpu_id);
            return view('yonggong.create')->with('dp', $fhz);
        }

        return redirect(url('yonggong'))->withErrors(['你没有新建权限。']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['dianpu_id' => 'required', 'name' => 'required|unique:yonggongs' ]);
        $input = $request->all();
        $input['dianpu_id'] = drc_selectremoveidpre($request['dianpu_id']);
        $input['birthday'] = Carbon::parse($request['birthday']);
        yonggong::create($input);
        return redirect(url('yonggong'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = yonggong::findOrFail($id);
        return view('yonggong.show',['task' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = yonggong::findOrFail($id);
        if(auth()->user()->can('manage',new Role) or (auth()->user()->can('dianzhang',new Role) and auth()->user()->dianpu_id ==$model->dianpu_id)) {
            return view('yonggong.edit',['task' => $model]);
        }
        return redirect(url('yonggong'))->withErrors(['你没有编辑权限。']);
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
        $model = yonggong::findOrFail($id);
        $this->validate($request, ['name' => 'required' ]);
        $input = $request->all();
        $model->fill($input)->save();
        return redirect(url('yonggong'));
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
            $model = yonggong::findOrFail($id);
            $model->delete();
            return redirect(url('yonggong'));
        }
        return redirect(url('yonggong'))->withErrors(['你没有删除权限。']);
    }

}