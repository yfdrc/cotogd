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
use App\Model\Tempjiazhang;
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
        $cachename = 'tmjzcx'; $cachevalue = 'tmjzhs';
        $cxnr = $request['cxnr']; $xshs = $request['xshs']; is_numeric($xshs)?null:$xshs=10;
        if($request['_method']){ Cache::forever($cachename, $cxnr); Cache::forever($cachevalue, $xshs); } else{ $cxnr = Cache::get($cachename); $xshs = Cache::get($cachevalue);}
        $cxtj = '%' . $cxnr . '%';
        $models = Tempjiazhang::orderBy('id', 'desc')->where([['dianpu_id', auth()->user()->dianpu_id],['addFlag', false],['name', 'like', $cxtj]])->orwhere([['dianpu_id', auth()->user()->dianpu_id],['addFlag', false],['tele', 'like', $cxtj]])->paginate($xshs);
        return view('temp.jiazhang.index', [ 'tasks' => $models]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->can('create',new Role)){
            return view('temp.jiazhang.create');
        }

        return redirect(url('tempjiazhang'))->withErrors(['你没有新建权限。']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['id' => 'required|unique:jiazhangs','name' => 'required','name' => 'required|unique:jiazhangs' ]);
        $input = $request->all();
        $input['dianpu_id'] = auth()->user()->dianpu_id;
        $input['buyZw'] = 0;
        $input['buyYw'] = 0;
        $input['buyMoney'] = 0;
        $input['studKssj'] = 0;
        $input['studKszh'] = 0;
        $input['leftKeshi'] = 0;
        Tempjiazhang::create($input);
        return redirect(url('tempjiazhang'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Tempjiazhang::findOrFail($id);
        return view('temp.jiazhang.show',['task' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Tempjiazhang::findOrFail($id);
        if(auth()->user()->can('manage',new Role) or (auth()->user()->can('update',new Role) and auth()->user()->dianpu_id ==$model->dianpu_id)) {
            return view('temp.jiazhang.edit',['task' => $model]);
        }
        return redirect(url('tempjiazhang'))->withErrors(['你没有编辑权限。']);
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
        $model = Tempjiazhang::findOrFail($id);
        $this->validate($request, [ 'id' => 'required','name' => 'required','name' => 'required' ]);
        $input = $request->all();
        $model->fill($input)->save();
        return redirect(url('tempjiazhang'));
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
            $model = Tempjiazhang::findOrFail($id);
            $model->delete();
            return redirect(url('jiazhang'));
        }
        return redirect(url('tempjiazhang'))->withErrors(['你没有删除权限。']);
    }

}