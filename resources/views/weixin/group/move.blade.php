@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-default">
        <div class="panel-heading">
            快捷方式：@can("create", new \App\Model\Role){!! link_to("wechatapigroup/create","增加微信用户组") !!} || @endcan @include("layouts.wx.wx04")
        </div>
        <div class="panel-body">
            @if (count($tasks) > 0)
                <div class="panel panel-info">
                    <div class="panel-heading">
                        移入微信用户组
                    </div>
                    <div class="panel-body">
                        <div class='form-group'>
                            {{ Form::label('tomove', '移入新用户组',['class'=>'col-sm-3 control-label']) }}
                            <div class='col-sm-6'>
                                {{ Form::select('group_id', $gp, null, ['class'=>'form-control']) }}
                                <button type="submit" id = "moveall" class="btn btn-warning">确定移入</button>
                            </div>
                        </div>

                        <table class='table table-striped task-table'>
                            <thead>
                            <th><input type="checkbox" id="selall"></th>
                            <th>序号</th>
                            <th>名称</th>
                            </thead>
                            <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="tomove" value="{{ $task->id }}">
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->id }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->name }}</div>
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
                    var tomove = $("input[name='tomove']");
                    var length = tomove.length;
                    var str = "";
                    for(var i=0;i<length;i++){
                        if(tomove[i].checked==true){
                            str = str + "," + tomove[i].value;
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
                    data: { _token:'{{csrf_token()}}' , type:'yssjkkb', nr: nr },
                    dataType: 'text',
                    success: function (data) {
                        window.location.reload()
                    }
                });
            }

        })
    </script>
@endsection
