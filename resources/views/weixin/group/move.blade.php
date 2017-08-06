@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-default">
        <div class="panel-heading">
            快捷方式：@can("create", new \App\Model\Role){!! link_to("tempjiazhang/create","增加临时家长") !!} || @endcan @include("layouts.shortcut21")
        </div>
        <div class="panel-body">
            @if (count($tasks) > 0)
                <table border="0">
                    <tr>
                        <td class="col-sm-2">
                            {{ Form::label('tomove', '移入新组') }}
                        </td>
                        <td class="col-sm-2">
                            {{ Form::select('group_id', $gp, null) }}
                        </td>
                        <td class="col-sm-2">
                            <button type="submit" id = "moveall" class="btn btn-warning">确定移入</button>
                        </td>
                    </tr>
                </table>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        用户批量移入新组
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped task-table'>
                            <thead>
                            <th><input type="checkbox" id="selall"></th>
                            <th>昵称</th>
                            <th>手机号</th>
                            <th>地址</th>
                            <th>小孩1</th>
                            <th>小孩2</th>
                            <th>所在组</th>
                            <th>加入时间</th>
                            </thead>
                            <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="tomove" value="{{ $task->openid }}">
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->nickname }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->remark }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->address }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->xh1name }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->xh2name }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->group->name }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ Carbon\Carbon::createFromTimestamp($task->subtime)->addHour(8)->toDateString() }}</div>
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
                    var tomove = $("input[name='tomove']");
                    var length = tomove.length;
                    for(var i=0;i<length;i++){
                        if( $(this).is(':checked')){
                            tomove[i].checked = true;
                        }else{
                            tomove[i].checked = false;
                        }
                    }
                });

                $("#moveall").click(function(){
                    var group_id = $("select[name='group_id']").val();
                    var tomove = $("input[name='tomove']");
                    var length = tomove.length;
                    var str = "";
                    for(var i=0;i<length;i++){
                        if(tomove[i].checked==true){
                            str = str + "," + tomove[i].value;
                        }
                    }
                    str= str.substr(1);
                    group_id = group_id.replace('TMPPRE','');
                    ajaxcl(str,group_id);
                })
            });

            function ajaxcl(nr,gid) {
                $.ajax({
                    url: "delsel",
                    type: "post",
                    async:false,
                    data: { _token:'{{csrf_token()}}' , type:'tomove', nr: nr, gid: gid },
                    dataType: 'text',
                    success: function (d) {
                        window.location.reload()
                    }
                    ,error:function (e,f) {
                        alert(JSON.stringify(e));
                    }
                });
            }

        })
    </script>
@endsection
