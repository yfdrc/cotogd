<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */
namespace App\Http\Controllers\Sjdr;

use App\Http\Controllers\Controller;
use App\Model\Excelkkb;
use App\Model\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Validator;

class YssjkkbController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cachename = 'yssjkkbcx'; $cachevalue = 'yssjkkbhs';
        $cxnr = $request['cxnr']; $xshs = $request['xshs']; is_numeric($xshs)?null:$xshs=10;
        if($request['_method']){ Cache::forever($cachename, $cxnr); Cache::forever($cachevalue, $xshs); } else{ $cxnr = Cache::get($cachename); $xshs = Cache::get($cachevalue);}
        $cxtj = '%' . $cxnr . '%';
        $models = Excelkkb::orderBy('id', 'asc')->where([['dianpu_id', auth()->user()->dianpu_id],['addFlag', false],['jzbh', 'like', $cxtj]])->paginate($xshs);
        return view('sjdr.kkb.index', [ 'tasks' => $models]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Excelkkb::findOrFail($id);
        return view('sjdr.kkb.show',['task' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Excelkkb::findOrFail($id);
        if(auth()->user()->can('manage',new Role) or (auth()->user()->can('update',new Role) and auth()->user()->dianpu_id ==$model->dianpu_id)) {
            return view('sjdr.kkb.edit',['task' => $model]);
        }
        return redirect(url('yssjkkb'))->withErrors(['你没有编辑权限。']);
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
        $model = Excelkkb::findOrFail($id);
        $this->validate($request, ['dianpu_id' => 'required','jzbh' => 'required','xybh' => 'required','xyname' => 'required','kcname' => 'required']);
        $input = $request->all();
        $model->fill($input)->save();
        return redirect(url('yssjkkb'));
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
            $model = Excelkkb::findOrFail($id);
            $model->delete();
            return redirect(url('yssjkkb'));
        }
        return redirect(url('yssjkkb'))->withErrors(['你没有删除权限。']);
    }

}