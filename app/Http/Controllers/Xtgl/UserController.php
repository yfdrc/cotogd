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
use App\Model\User;
use DB;
use Illuminate\Http\Request;

class UserController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        if(auth()->user()->can('manage',new Role)) {
//            $models = user::orderBy('name', 'asc')->paginate(10);
//        }else{
        $models = user::orderBy('name', 'asc')->where('dianpu_id',auth()->user()->dianpu_id)->paginate(10);
//        }
        return view('user.index', [ 'tasks' => $models]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $rid = auth()->user()->getRoleid();
        $roles = drc_selectidname('roles','id',$rid,'<=','label');
//        if(auth()->user()->can('manage',new Role)){
//            $dps = drc_selectidname('dianpus');
//            return view('user.create',compact('roles','dps'));
//        }else
        if(auth()->user()->can('dianzhang',new Role)){
            $dps = drc_selectidname('dianpus','id',auth()->user()->dianpu_id);
            return view('user.create',compact('roles', 'dps'));
        }
        return redirect(url('user'))->withErrors(['你没有新建权限。']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['yzm_confirmation'] = 'cotoGD123456??';
        $this->validate($request,[
            'dianpu_id' => 'required',
            'name' => 'required|max:128',
            'email' => 'required|email|max:128|unique:users',
            'password' => 'required|confirmed|min:6',
            'yzm' => 'required|confirmed'
        ]);
        $input = $request->all();
        $input['dianpu_id'] = drc_selectremoveidpre($request['dianpu_id']);
        $input['password'] = bcrypt($request['password']);
        user::create($input);

        DB::table('role_user')->insert([
            'user_id' => User::where('name',$input['name'])->first()->id,
            'role_id' => drc_selectremoveidpre($request['role_id']),
        ]);
        return redirect(url('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = user::findOrFail($id);
        return view('user.show',['task' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = user::findOrFail($id);
        $rid1 = auth()->user()->getRoleid();
        $rid2 = User::find($id)->getRoleid();
        if($rid1>=$rid2) {
            $roles = drc_selectidname('roles', 'id', $rid1, '<=', 'label');
            if ($id == auth()->user()->id or auth()->user()->can('manage', new Role) or (auth()->user()->can('dianzhang', new Role) and auth()->user()->dianpu_id == $task->dianpu_id)) {
                return view('user.edit', compact('roles', 'task'));
            }
        }
        return view('user.show',['task' => $task])->withErrors(['你没有编辑权限。']);
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
        $model = user::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|max:128',
            'email' => 'required|email|max:128'
        ]);
        $model['name'] = $request['name'];
        $model['email'] = $request['email'];
        if ($request['pass'] != '') {
            $model['password'] = bcrypt($request['pass']);
        }
        $model->save();
        $rid = drc_selectremoveidpre($request['role_id']);
        DB::table('role_user')->where('user_id',$id)->update(['role_id' => $rid]);
        return redirect(url('user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = user::findOrFail($id);
        if(auth()->user()->can('manage',new Role) or (auth()->user()->can('dianzhang',new Role) and auth()->user()->dianpu_id ==$model->dianpu_id)) {
            $model->delete();
            return redirect(url('user'));
        }
        return redirect(url('user'))->withErrors(['你没有删除权限。']);
    }
}