<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */
namespace App\Http\Controllers\Jcsj;

use App\Http\Controllers\Controller;
use App\Model\Jiazhang;
use App\Model\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Validator;

class JiazhangController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cachename = 'jzcx'; $cachevalue = 'jzhs';
        $cxnr = $request['cxnr']; $xshs = $request['xshs']; is_numeric($xshs)?null:$xshs=10;
        if($request['_method']){ Cache::forever($cachename, $cxnr); Cache::forever($cachevalue, $xshs); } else{ $cxnr = Cache::get($cachename); $xshs = Cache::get($cachevalue);}
        if(is_numeric($xshs)){ if($xshs<1){$xshs = 10; }} else { $xshs = 10; }
        $cxtj = '%' . $cxnr . '%';
//        if(auth()->user()->can('manage',new Role)) {
//            $models = jiazhang::orderBy('id', 'desc')->where('bh', 'like', $cxtj)->orwhere('name', 'like', $cxtj)->orwhere('tele', 'like', $cxtj)->paginate($xshs);
//        }else{
//            $models = jiazhang::orderBy('id', 'desc')->where([['dianpu_id', auth()->user()->dianpu_id],['bh', 'like', $cxtj]])->orwhere([['dianpu_id', auth()->user()->dianpu_id],['name', 'like', $cxtj]])->orwhere([['dianpu_id', auth()->user()->dianpu_id],['tele', 'like', $cxtj]])->paginate($xshs);
//        }
        $models = jiazhang::orderBy('id', 'desc')->where([['dianpu_id', auth()->user()->dianpu_id],['bh', 'like', $cxtj]])->orwhere([['dianpu_id', auth()->user()->dianpu_id],['name', 'like', $cxtj]])->orwhere([['dianpu_id', auth()->user()->dianpu_id],['tele', 'like', $cxtj]])->orwhere([['dianpu_id', auth()->user()->dianpu_id],['whenStud', 'like', $cxtj]])->paginate($xshs);
        return view('jiazhang.index', [ 'tasks' => $models]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->can('create',new Role)){
            return view('jiazhang.create');
        }

        return redirect(url('jiazhang'))->withErrors(['你没有新建权限。']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['bh' => 'required|unique:jiazhangs','name' => 'required','name' => 'required|unique:jiazhangs' ]);
        $input = $request->all();
        $input['dianpu_id'] = auth()->user()->dianpu_id;
        jiazhang::create($input);
        return redirect(url('jiazhang'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = jiazhang::findOrFail($id);
        return view('jiazhang.show',['task' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = jiazhang::findOrFail($id);
        if(auth()->user()->can('manage',new Role) or (auth()->user()->can('update',new Role) and auth()->user()->dianpu_id ==$model->dianpu_id)) {
            return view('jiazhang.edit',['task' => $model]);
        }
        return redirect(url('jiazhang'))->withErrors(['你没有编辑权限。']);
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
        $model = jiazhang::findOrFail($id);
        $this->validate($request, [ 'bh' => 'required','name' => 'required','name' => 'required' ]);
        $input = $request->all();
        $model->fill($input)->save();
        return redirect(url('jiazhang'));
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
            return redirect(url('jiazhang'));
        }
        return redirect(url('jiazhang'))->withErrors(['你没有删除权限。']);
    }

}