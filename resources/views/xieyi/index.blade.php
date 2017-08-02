@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-default">
        <div class="panel-heading">
            快捷方式：@can("create", new \App\Model\Role){!! link_to("xieyi/create","增加协议") !!} || @endcan @include("layouts.shortcut11")
        </div>
        <div class="panel-body">
            <div>
                {!! Form::open( ["method"=>"put", "class"=>"form-inline"]) !!}
                <div class="form-group">
                    每页行数：<input type="text" class="form-control" name="xshs" value="{!! Illuminate\Support\Facades\Cache::get("xieyhs") !!}">
                </div>
                <div class="form-group">
                    查询：<input type="text" class="form-control" name="cxnr" value="{!! Illuminate\Support\Facades\Cache::get("xieycx") !!}" placeholder="家长姓名协议编号课包">
                </div>
                <button type="submit" class="btn btn-default">确定</button>
                {!! Form::close() !!}
            </div>
            @if (count($tasks) > 0)
                <div class="panel panel-info">
                    <div class="panel-heading">
                        协议列表
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped task-table'>
                            <thead>
                            <th>家长姓名</th>
                            <th>协议编号</th>
                            <th>课包名称</th>
                            <th>中文课时</th>
                            <th>英文课时</th>
                            <th>协议金额</th>
                            <th>签约日期</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class='table-text'>
                                        <div>{{ $task->jzname }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->name }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->kebao }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->ksZw }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->ksYw }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->jinE }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->date }}</div>
                                    </td>
                                    <td>
                                        <a href="xieyi\{{ $task->id }}">详情</a> @can("update", new \App\Model\Role) | <a href="xieyi\{{ $task->id }}\edit">编辑</a> @endcan @can("delete", new \App\Model\Role) | <a href="xieyi\{{ $task->id }}">删除</a>@endcan
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
