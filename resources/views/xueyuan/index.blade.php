@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-default">
        <div class="panel-heading">
            快捷方式：@can("create", new \App\Model\Role){!! link_to("xueyuan/create","增加学员") !!} || @endcan @include("layouts.shortcut11")
        </div>
        <div class="panel-body">
            <div>
                {!! Form::open( ["method"=>"put", "class"=>"form-inline"]) !!}
                <div class="form-group">
                    每页行数：<input type="text" class="form-control" name="xshs" value="{!! Illuminate\Support\Facades\Cache::get("xueyhs") !!}">
                </div>
                <div class="form-group">
                    查询：<input type="text" class="form-control" name="cxnr" value="{!! Illuminate\Support\Facades\Cache::get("xueycx") !!}" placeholder="家长姓名学员编号姓名">
                </div>
                <button type="submit" class="btn btn-default">确定</button>
                {!! Form::close() !!}
            </div>
            @if (count($tasks) > 0)
                <div class="panel panel-info">
                    <div class="panel-heading">
                        学员列表
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped task-table'>
                            <thead>
                            <th>家长姓名</th>
                            <th>学员编号</th>
                            <th>学员姓名</th>
                            <th>学习课时</th>
                            <th>折合课时</th>
                            <th>出生日期</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class='table-text'>
                                        <div>{{ $task->jzname }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->bh }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->name }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->studKssj }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->studKszh }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->birthday }}</div>
                                    </td>
                                    <td>
                                        <a href="xueyuan\{{ $task->id }}">详情</a> @can("update", new \App\Model\Role) | <a href="xueyuan\{{ $task->id }}\edit">编辑</a> @endcan @can("delete", new \App\Model\Role) | <a href="xueyuan\{{ $task->id }}">删除</a>@endcan
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
