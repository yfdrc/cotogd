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
use App\Model\Tempyonggong;
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
        $cachename = 'tmygcx'; $cachevalue = 'tmyghs';
        $cxnr = $request['cxnr']; $xshs = $request['xshs']; is_numeric($xshs)?null:$xshs=10;
        if($request['_method']){ Cache::forever($cachename, $cxnr); Cache::forever($cachevalue, $xshs); } else{ $cxnr = Cache::get($cachename); $xshs = Cache::get($cachevalue);}
        $cxtj = '%' . $cxnr . '%';
        $models = Tempyonggong::orderBy('name', 'asc')->where([['dianpu_id', auth()->user()->dianpu_id],['addFlag', false],['name', 'like', $cxtj]])->paginate($xshs);
        return view('temp.yonggong.index', [ 'tasks' => $models]);
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
        if(auth()->user()->can('create',new Role)){
            $fhz = drc_selectidname('dianpus','id',auth()->user()->dianpu_id);
            return view('temp.yonggong.create')->with('dp', $fhz);
        }

        return redirect(url('tempyonggong'))->withErrors(['你没有新建权限。']);
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
        Tempyonggong::create($input);
        return redirect(url('tempyonggong'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Tempyonggong::findOrFail($id);
        return view('temp.yonggong.show',['task' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Tempyonggong::findOrFail($id);
        if(auth()->user()->can('manage',new Role) or (auth()->user()->can('update',new Role) and auth()->user()->dianpu_id ==$model->dianpu_id)) {
            return view('temp.yonggong.edit',['task' => $model]);
        }
        return redirect(url('tempyonggong'))->withErrors(['你没有编辑权限。']);
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
        $model = Tempyonggong::findOrFail($id);
        $this->validate($request, ['name' => 'required' ]);
        $input = $request->all();
        $model->fill($input)->save();
        return redirect(url('tempyonggong'));
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
            $model = Tempyonggong::findOrFail($id);
            $model->delete();
            return redirect(url('tempyonggong'));
        }
        return redirect(url('tempyonggong'))->withErrors(['你没有删除权限。']);
    }

}