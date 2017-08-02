@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-default">
        <div class="panel-heading">
            快捷方式：@can("create", new \App\Model\Role){!! link_to("tempjiazhang/create","增加临时家长") !!} || @endcan @include("layouts.shortcut21")
        </div>
        <div class="panel-body">
            <div>
                {!! Form::open( ["method"=>"put", "class"=>"form-inline"]) !!}
                <div class="form-group">
                    每页行数：<input type="text" class="form-control" name="xshs" value="{!! Illuminate\Support\Facades\Cache::get("tmjzhs") !!}">
                </div>
                <div class="form-group">
                    查询：<input type="text" class="form-control" name="cxnr" value="{!! Illuminate\Support\Facades\Cache::get("tmjzcx") !!}" placeholder="家长编号姓名电话">
                </div>
                <button type="submit" class="btn btn-default">确定</button>
                {!! Form::close() !!}
            </div>
            @if (count($tasks) > 0)
                <div class="panel panel-info">
                    <div class="panel-heading">
                        临时家长列表
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped task-table'>
                            <thead>
                            <th><input type="checkbox" id="selall"></th>
                            <th>家长编号</th>
                            <th>家长姓名</th>
                            <th>家长手机</th>
                            <th>剩余课时</th>
                            <th>排课时间</th>
                            <th><button type="submit" id = "delall" class="btn btn-warning">删除所选</button></th>
                            </thead>
                            <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="todel" value="{{ $task->id }}">
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->bh }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->name }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->tele }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->leftKeshi }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->whenStud }}</div>
                                    </td>
                                    <td>
                                        <a href="tempjiazhang\{{ $task->id }}">详情</a> @can("update", new \App\Model\Role) | <a href="tempjiazhang\{{ $task->id }}\edit">编辑</a> @endcan @can("delete", new \App\Model\Role) | <a href="tempjiazhang\{{ $task->id }}">删除</a>@endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $tasks->links() !!}
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(function(){
                $("#selall").change(function(){
                    var todel = $("input[name='todel']");
                    var length = todel.length;
                    for(var i=0;i<length;i++){
                        if( $(this).is(':checked')){
                            todel[i].checked = true;
                        }else{
                            todel[i].checked = false;
                        }
                    }
                });

                $("#delall").click(function(){
                    var todel = $("input[name='todel']");
                    var length = todel.length;
                    var str = "";
                    for(var i=0;i<length;i++){
                        if(todel[i].checked==true){
                            str = str + "," + todel[i].value;
                        }
                    }
                    str= str.substr(1);
                    ajaxcl(str);
                })
            });

            function ajaxcl(nr) {
                $.ajax({
                    url: "delsel",
                    type: "post",
                    async:false,
                    data: { _token:'{{csrf_token()}}' , type:'tempjiazhang', nr: nr },
                    dataType: 'text',
                    success: function (data) {
                        window.location.reload()
                    }
                });
            }

        })
    </script>
@endsection
