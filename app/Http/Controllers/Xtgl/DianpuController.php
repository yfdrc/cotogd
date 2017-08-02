<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2016/8/30
 * Time: 10:37
 */
namespace App\Http\Controllers\Xtgl;

use App\Http\Controllers\Controller;
use App\Model\Dianpu;
use App\Model\Role;
use Illuminate\Http\Request;
use Validator;

class DianpuController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->can('manage', new Role)) {
            $models = Dianpu::orderBy('name', 'asc')->paginate(10);
        } else
        {
            $models = Dianpu::orderBy('name', 'asc')->where('id', auth()->user()->dianpu_id)->paginate(10);
        }

        return view('dianpu.index', [ 'tasks' => $models]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->can('manage', new Role)){
            return view('dianpu.create');
        }
        return redirect(url('dianpu'))->withErrors(['你没有新建权限。']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [ 'name' => 'required|unique:dianpus' ]);
        $input = $request->all();
        dianpu::create($input);
        return redirect(url('dianpu'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Dianpu::findOrFail($id);
        return view('dianpu.show',['task' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->can('dianzhang', new Role)){
            $model = Dianpu::findOrFail($id);
            return view('dianpu.edit',['task' => $model]);
        }
        return redirect(url('dianpu'))->withErrors(['你没有编辑权限。']);
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
        $model = Dianpu::findOrFail($id);
        $this->validate($request, [ 'name' => 'required' ]);
        $input = $request->all();
        $model->fill($input)->save();
        return redirect(url('dianpu'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->can('manage', new Role)) {
            $model = Dianpu::findOrFail($id);
            $model->delete();
            return redirect(url('dianpu'));
        }
        return redirect(url('dianpu'))->withErrors(['你没有删除权限。']);
    }

}